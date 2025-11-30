<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Rider;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\RiderRepository;
use App\Services\PaymentGatewayService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Stripe\Stripe;
use PDF;

class RiderController extends Controller
{
    public function index(Request $request): View
    {
        $search   = $request->input('search');
        $joinDate = $request->input('join_date');
        $orderBy  = $request->input('order_by');
        $perPage = $request->query('per_page', 10);

        $riders = RiderRepository::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                });
            })
            ->when($joinDate, function ($query) use ($joinDate) {
                [$startDate, $endDate] = explode(' to ', $joinDate);
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            })
            ->orderBy('created_at', $orderBy === 'oldest' ? 'asc' : 'asc')
            ->paginate($perPage);
        $countries = Country::all();

        return view('riders.index', [
            'data' => $riders,
            'countries' => $countries,
        ]);
    }

    public function store(Request $request)
    {
        $country = Country::where('phone_code', $request->country_code)->first();

        $countryCode = strtoupper($country->code);
        $validator = Validator::make($request->all(), [
            'mobile' => [
                'required',
                'phone:' . $countryCode,
                'unique:users,mobile',
            ],
        ], [
            'mobile.required' => 'The mobile number is required.',
            'mobile.phone' => 'The phone number is not valid for the selected country.',
        ]);

        $mobile =$this->normalizePhoneNumber($request->mobile, $request->country_code);

        if (User::where('mobile', $mobile)->exists()) {
            $validator = Validator::make([], []);
            $validator->errors()->add('mobile', 'The mobile number is already taken.');
            throw new ValidationException($validator);
        }
        elseif ($validator->fails()) {
             throw new ValidationException($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'mobile' =>     $mobile,
            'gender' => $request->gender,
            'country_iso' => $country->code,
            'password' => Hash::make($request->mobile),
        ]);

        Rider::create([
            'user_id' => $user->id,
        ]);
        Wallet::create(['user_id' => $user->id,'amount' => 0]);
        $user->assignRole('rider');
        return redirect()->route('riders.index')->with('success', 'Rider created successfully!');
    }

    public function edit($id): View
    {
        $countries = Country::all();
        $rider = Rider::find($id);

        $iso = Country::where('code', $rider->user->country_iso)->first();
        $orders = $rider->orders()->get();
        $transactions = $rider->transactions()->get();
        $wallet = $rider->user->wallet()->first();

        return view('riders.edit', compact('rider','countries','iso','orders','transactions','wallet'));
    }
    public function updateStatus(Request $request, User $user)
    {
        $user->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status updated successfully!');
    }
    public function update(Request $request, $id)
    {
        $country = Country::where('phone_code', $request->country_code)->first();
        $countryCode = strtoupper($country->code);

        $validator = Validator::make($request->all(), [
            'mobile' => [
                'required',
                'phone:' . $countryCode,
            ],
            'email' => 'required',
            'name' => 'required',
        ], [
            'mobile.required' => 'The mobile number is required.',
            'mobile.phone' => 'The phone number is not valid for the selected country.',
        ]);

        $mobile =$this->normalizePhoneNumber($request->mobile, $request->country_code);
        if ($validator->fails()) {
             throw new ValidationException($validator);
        }

        $rider = Rider::findOrFail($id);
        $user = User::findOrFail($rider->user_id);

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email ?? '',
            'country_iso' => $country->code ?? '',
            'gender' => $request->gender ?? '',
            'address' => $request->address ?? '',
            'mobile' => $mobile,
        ]);

        $riderData = [
            'user_id' => $rider->user_id,

        ];

        // Update rider
        $rider->update($riderData);

        if($rider->stripe_customer == null){
            $publishedKey  = config('services.stripe.public_key');
            $secretKey = config('services.stripe.key');

            Stripe::setApiKey($secretKey);
            if ($secretKey && $publishedKey) {
                PaymentGatewayService::makeCustomer(id:$user->id,name:$user->name, email:$user->email, role:'rider');
            }
        }

        return redirect()->route('riders.index')->with('success', 'Rider updated successfully!');
    }
    public function destroy($id)
    {
        $rider = Rider::findOrFail($id);
        $rider->delete();
        return redirect()->route('riders.index')->with('success', 'Rider deleted successfully!');
    }

    public function generateExport(Request $request)
    {
        $search = $request->query('search');
        $joinDate = $request->query('join_date');
        $orderBy = $request->query('order_by');
        $page_num = $request->query('page', 1);
        $exportType = $request->query('export_type');

        $riders = RiderRepository::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                });
            })
            ->when($joinDate, function ($query) use ($joinDate) {
                if (strpos($joinDate, ' to ') !== false) {
                    list($startDate, $endDate) = explode(' to ', $joinDate);
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::parse($startDate)->startOfDay(),
                        \Carbon\Carbon::parse($endDate)->endOfDay()
                    ]);
                }
            })
            ->orderBy('created_at', $orderBy === 'oldest' ? 'asc' : 'desc')
            ->withTrashed()
            ->paginate(10, ['*'], 'page', $page_num);

        $data = $riders->items();

        $csvContent = "SL,Date,Name,Mobile Number, On Trip\n";

        foreach ($data as $index => $report) {
            $csvContent .= implode(',', [
                $index + 1,
                $report->created_at,
                $report->user->name ?? 'N/A',
                $report->user->mobile ?? 'N/A',
                $report->on_trip ?? 'N/A',
            ]) . "\n";
        }

        if ($exportType === 'pdf') {
            $pdf = Pdf::loadView('riderPdf', [
                'riders' => $data,
                'page_num' => $page_num,
            ]);
            return $pdf->stream("report-{$page_num}.pdf");
        }
        else{
            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="report.csv"');
        }

        return redirect()->back()->with('error', 'Invalid export type selected.');
    }

}
