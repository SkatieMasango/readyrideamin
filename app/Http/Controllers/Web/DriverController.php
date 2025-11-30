<?php

namespace App\Http\Controllers\Web;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Driver;
use App\Models\Fleet;
use App\Models\Service;
use App\Models\User;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use App\Models\Wallet;
use App\Models\Media;
use App\Services\AuthService;
use App\Services\DriverService;
use App\Services\PaymentGatewayService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Stripe\Stripe;
use Illuminate\Support\Facades\Storage;
use App\Repositories\DriverRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WithdrawRepository;
use App\Services\NotificationServices;
use Carbon\Carbon;
use PDF;

class DriverController extends Controller
{
    protected $authService;

    protected $driverService;

    public function __construct(AuthService $authService, DriverService $driverService)
    {
        $this->authService = $authService;
        $this->driverService = $driverService;
    }

    public function show(Request $request): View
    {
        $search   = $request->input('search');
        $joinDate = $request->input('join_date');
        $orderBy  = $request->input('order_by','oldest');
        $perPage = $request->query('per_page', 10);

        $drivers = DriverRepository::query()
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
            ->orderBy('created_at', $orderBy === 'oldest' ? 'asc' : 'desc')
            ->paginate($perPage);
        $countries = Country::all();


        return view('drivers.view', [
            'data' => $drivers,
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
            'mobile' => $mobile,
            'gender' => $request->gender,
            'status' => Status::PENDING_APPROVAL->value,
            'country_iso' => $country->code,
            'password' => Hash::make($request->mobile),
        ]);

        Driver::create([
            'user_id' => $user->id,
            'driver_status' => 'Offline',
        ]);
        Wallet::create(['user_id' => $user->id,'amount' => 0]);
        $user->assignRole('driver');

        return redirect()->route('drivers.view')->with('success', 'Driver created successfully!');
    }
    public function edit($id): View
    {
        $countries = Country::all();
        $driver = Driver::find($id);

        $services = Service::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' => $id,
            'name' => $name,
        ])->values()->toArray();
        $vehicleModels = VehicleModel::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' => $id,
            'name' => $name,
        ])->values()->toArray();
        $fleets = Fleet::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' => $id,
            'name' => $name,
        ])->values()->toArray();
        $vehicleColors = VehicleColor::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' => $id,
            'name' => $name,
        ])->values()->toArray();

        $iso = Country::where('code', $driver->user?->country_iso)->first();
        $orders = $driver->orders()->get();
        $transactions = $driver->transactions()->get();
        $wallet = $driver->user->wallet()->first();
        $ratings = $driver->ratings()->get();

        return view('drivers.edit', compact('driver','countries','fleets','vehicleModels','vehicleColors','services','iso','orders','transactions','wallet','ratings'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $user->update([
            'status' => $request->status,
        ]);

        if($request->status == 'blocked' || $request->status == 'pending_approval'){
            $user->driver->update(['driver_status' => 'Offline']);
        }
        if($user->status == 'approved'){
            $title = "Status Update";
            $body = "Your account has been approved, you can now login to your account.";

            $tokens = UserRepository::query()->where('id', $user->id)->whereNotNull('device_token')
                ->pluck('device_token')
                ->toArray();
            NotificationServices::sendNotification($body, $tokens, $title);
        }

        return back()->with('success', 'Status updated successfully!');
    }

    public function update(Request $request, $id)
    {
        $country = Country::where('phone_code', $request->country_code)->first();
        $countryCode = strtoupper($country->code);

        $driver = Driver::findOrFail($id);
        $user = User::findOrFail($driver->user_id);

        $validator = Validator::make($request->all(), [
            'mobile' => [
                'required',
                'phone:' . $countryCode,
            ],
                'name' => 'required',
                'email' => 'required',

            ], [
                'mobile.required' => 'The mobile number is required.',
                'mobile.phone' => 'The phone number is not valid for the selected country.',
            ]);

            $mobile = $this->normalizePhoneNumber($request->mobile, $request->country_code);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email ?? '',
                'country_iso' => $country->code ?? '',
                'gender' => $request->gender ?? '',
                'address' => $request->address ?? '',
                'mobile' => $mobile,
            ]);

            $driverData = [
                'user_id' => $driver->user_id,
                'vehicle_id' => $request->vehicle_id ?? null,
                'vehicle_color_id' => $request->vehicle_color_id ?? null,
                'vehicle_production_year' => $request->vehicle_production_year ?? null,
                'vehicle_plate' => $request->vehicle_plate?? null,
                'account_number' => $request->account_number ?? null,
                'bank_routing_number' => $request->bank_routing_number ?? null,
                'bank_swift' => $request->bank_swift ?? null,
                // 'fleet_id' => $request->fleet_id ?? null,
                'service_id' => $request->service_id ?? null,
                'bank_name' => $request->bank_name ?? null,
            ];

            $driver->update($driverData);

            if($driver->stripe_customer == null){

                $publishedKey  = config('services.stripe.public_key');
                $secretKey = config('services.stripe.key');

                Stripe::setApiKey($secretKey);
                if ($secretKey && $publishedKey) {
                    PaymentGatewayService::makeCustomer(id:$user->id,name:$user->name, email:$user->email, role:'driver');
                }
            }

            return redirect()->route('drivers.view')->with('success', 'Driver updated successfully!');
    }

    public function updateDocuments(Request $request, $id){

        $driver = Driver::findOrFail($id);
        $user = User::findOrFail($driver->user_id);

        $uploadedFiles = [];
        $documentTypes = array_keys($request->file());

        foreach ($documentTypes as $type) {
            if ($request->hasFile($type)) {
                $existingDocuments = $user->documents()->where('type', $type)->get();
                foreach ($existingDocuments as $existingDocument) {
                    Storage::disk('public')->delete($existingDocument->path);
                    $existingDocument->delete();
                }
                $files = is_array($request->file($type)) ? $request->file($type) : [$request->file($type)];

                foreach ($files as $file) {
                    $filePath = $file->store("documents/{$type}", 'public');
                    $document = new Media([
                        'name' => $file->getClientOriginalName(),
                        'path' => $filePath,
                        'type' => $type,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ]);
                    $user->documents()->save($document);
                    $uploadedFiles[$type][] = asset('storage/'.$filePath);
                }
                }
            }
        return redirect()->route('drivers.view')->with('success', 'Driver updated successfully!');
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();
        return redirect()->route('drivers.view')->with('success', 'Driver deleted successfully!');
    }

    public function insertTransaction(Request $request)
    {
        $driver = Driver::findOrFail($request->driver_id);
        $wallet = Wallet::where('user_id', $driver->user_id)->first();

        if($request->type == 'debit'){
            if( $wallet->amount > $request->amount ){
                $transaction = TransactionRepository::createTransaction($request, $driver->id, 'withdraw',$request->type ,$request->amount );
                $wallet->amount = $wallet->amount - $request->amount;
                $wallet->update();
                WithdrawRepository::requestWithdrawByDriver($request,$driver->id, $transaction->id);

            }else{
                return redirect()->back()->with('error', 'Insufficient balance');
            }
        }
        else{
            $transaction = TransactionRepository::createTransaction($request, $driver->id, 'received',$request->type ,$request->amount );
            $wallet->amount = $wallet->amount + $request->amount;
            $wallet->update();
            }
      return redirect()->back()->with('success', $request->type . ' successfully!');

    }

    public function generateExport(Request $request)
{
    $search = $request->query('search');
    $joinDate = $request->query('join_date');
    $orderBy = $request->query('order_by');
    $page_num = $request->query('page', 1);
    $exportType = $request->query('export_type');

    $drivers = DriverRepository::query()
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

    $data = $drivers->items();

    $csvContent = "SL,Date,Name,Mobile Number,Emergency Contact,Certificate Number,Vehicle Color,Vehicle Production Year,Vehicle Plate, Rating, Account   Number, Bank Name, Bank Routing Number, Driver Status, Current Location, On Trip\n";

    foreach ($data as $index => $report) {
        $csvContent .= implode(',', [
            $index + 1,
            $report->created_at,
            $report->user->name ?? 'N/A',
            $report->user->mobile ?? 'N/A',
            $report->emergency_contact ?? 'N/A',
            $report->certificate_number ?? 'N/A',
            $report->vehicle_color_id ?? 'N/A',
            $report->vehicle_production_year ?? 'N/A',
            $report->vehicle_plate ?? 'N/A',
            $report->rating ?? 'N/A',
            $report->account_number ?? 'N/A',
            $report->bank_name ?? 'N/A',
            $report->bank_routing_number ?? 'N/A',
            $report->driver_status ?? 'N/A',
            $report->current_location ?? 'N/A',
            $report->on_trip ?? 'N/A',
        ]) . "\n";
    }

    if ($exportType === 'pdf') {
        $pdf = Pdf::loadView('pdf', [
            'drivers' => $data,
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
