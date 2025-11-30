<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ReviewParameter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReviewParameterController extends Controller
{
    public function index(): View
    {
        $reviewParameters = ReviewParameter::all();
        return view('review-parameter.index',compact('reviewParameters'));
    }

    public function create(): View
    {
        return view('review-parameter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|boolean',
        ]);

        ReviewParameter::create($validated);

        return redirect()->route('review-parameter.index')->with('success', 'Review created successfully.');
    }

    public function edit($id): View
    {
        $reviewParameter = ReviewParameter::find($id);

        return view('review-parameter.edit', compact('reviewParameter'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|boolean',
        ]);

        $reviewParameter = ReviewParameter::findOrFail($id);
        $reviewParameter->update($validated);

        return redirect()->back()->with('success', 'Review updated successfully.');
    }

    public function destroy( $id)
    {
        $reviewParameter = ReviewParameter::find($id);
        $reviewParameter->delete();
        return redirect()->route('review-parameter.index')->with('success', 'Review Reason deleted!');
    }
}
