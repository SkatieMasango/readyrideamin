<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CancelReason;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CancelReasonController extends Controller
{
    public function index(): View
    {
        $cancelReasons = CancelReason::all();
        return view('cancel-reason.index',compact('cancelReasons'));
    }

    public function create(): View
    {
        return view('cancel-reason.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'user_type' => 'required|string|max:255',
        'status' => 'nullable|boolean',
    ]);

    CancelReason::create($validated);

    return redirect()->route('cancel-reason.index')->with('success', 'Cancel Reason created successfully.');
}

public function edit($id): View
{
    $cancelReason = CancelReason::find($id);

    return view('cancel-reason.edit', compact('cancelReason'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'user_type' => 'required|string|max:255',
        'status' => 'nullable|boolean',
    ]);

    $cancelReason = CancelReason::findOrFail($id);
    $cancelReason->update($validated);

    return redirect()->back()->with('success', 'Cancel Reason updated successfully.');
}

public function destroy( $id)
{
    $cancelReason = CancelReason::find($id);
    $cancelReason->delete();
    return redirect()->route('cancel-reason.index')->with('success', 'Cancel Reason deleted!');
}

}
