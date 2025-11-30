<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FleetsController extends Controller
{
    public function index(): View
    {
        $fleets = Fleet::all();
        return view('fleets.index',compact('fleets'));
    }

    public function create(): View
    {
        return view('fleets.create');
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|numeric',
        'account_number' => 'required|string|max:255',
        'mobile_number' => 'required|numeric',
        'commission_share_percent' => 'nullable|integer|min:0|max:100',
        'commission_share_flat' => 'nullable|numeric|min:0',
        'address' => 'nullable|string|max:255',
        'user_name' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:6',
        'fee_multiplier' => 'nullable',
    ]);

    if ($request->filled('password')) {
        $validated['password'] = Hash::make($request->password);
    }

    Fleet::create($validated);

    return redirect()->route('fleets.index')->with('success', 'Fleet saved successfully!');
}

    public function edit($id): View
    {
        $fleet = Fleet::find($id);
        return view('fleets.edit',compact('fleet'));
    }
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|numeric',
        'account_number' => 'required|string|max:255',
        'mobile_number' => 'required|numeric',
        'commission_share_percent' => 'nullable|integer|min:0|max:100',
        'commission_share_flat' => 'nullable|numeric|min:0',
        'address' => 'nullable|string|max:255',
        'user_name' => 'nullable|string|max:255',
        'password' => 'nullable|string|min:6',
        'fee_multiplier' => 'nullable',
    ]);

    if ($request->filled('password')) {
        $validated['password'] = Hash::make($request->password);
    } else {
        unset($validated['password']);
    }

    $fleet = Fleet::find($id);
    $fleet->update($validated);

    return redirect()->back()->with('success', 'Fleet updated successfully!');
}

public function destroy( $id)
{
    $fleet = Fleet::find($id);
    $fleet->delete();
    return redirect()->route('fleets.index')->with('success', 'Fleet deleted!');
}


}
