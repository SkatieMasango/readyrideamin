<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Payout;
use App\Models\Withdraw;
use App\Services\PayoutService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $dailyWithdraws = Withdraw::selectRaw('MIN(id) as id, DATE(created_at) as date, COUNT(*) as total, SUM(amount) as amount')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'desc')
            ->get();
       $methodAmounts = Withdraw::selectRaw('DATE(created_at) as date, method, SUM(amount) as method_amount')
            ->groupBy(DB::raw('DATE(created_at)'), 'method')
            ->orderBy('date', 'desc')
            ->get();

        return view('payouts.index', ['withdraws' => $dailyWithdraws, 'methodAmounts' => $methodAmounts]);
    }

     public function show(Request $request): View
    {
        $date = $request->query('date');
        $id = $request->query('id');
        $withdraws = Withdraw::whereDate('created_at', $date)
        ->get();

    return view('payouts.show', compact('withdraws', 'date','id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $countries = Country::all();
        return view('payouts.create', ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'currency' => 'required|string',
            'type' => 'required|string',
            'payment_status' => 'required|boolean',
            'api_key' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('payouts', 'public');
        }
        if( $request->type === 'stripe'){
            $request->validate([
                'api_key' => 'required',
            ]);
            $paymentGateway = PayoutService::StorePayout($request);

        }
        Payout::create([
            'name' => $request->name,
            'description' => $request->description,
            'currency_name' => $request->currency,
            'type' => $request->type,
            'payment_status' => $request->payment_status,
            'payout_gateway_id' => $paymentGateway->id ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('payouts.view')->with('success', 'Payout created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function view(): View
    {
        $payouts = Payout::paginate(perPage: 10, page: 1);

        return view('payouts.view', ['payouts' => $payouts]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $countries = Country::all();
        $payout = Payout::find($id);
        return view('payouts.edit',compact('countries','payout'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'currency' => 'required|string',
            'type' => 'required|string',
            'payment_status' => 'required',
            'api_key' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $payout = Payout::findOrFail($id);

        $imagePath = $payout->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('payouts', 'public');
        }

        if ($request->type === 'stripe') {
            $request->validate([
                'api_key' => 'required',
            ]);

            if(!$payout->payout_gateway_id){
                $paymentGateway = PayoutService::StorePayout($request);
            }else{
                $paymentGateway = PayoutService::UpdatePayout($request,$payout->payout_gateway_id);
            }

        }

        $payout->update([
            'name' => $request->name,
            'description' => $request->description,
            'currency_name' => $request->currency,
            'type' => $request->type,
            'payment_status' => $request->payment_status,
            'payout_gateway_id' => $paymentGateway->id ?? null,
            'image' => $imagePath,

        ]);
        return back()->with('success', 'Payout updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $payout = Payout::find($id);
        $payout->delete();
        return redirect()->route('payouts.view')->with('success', 'Service deleted!');
    }
}
