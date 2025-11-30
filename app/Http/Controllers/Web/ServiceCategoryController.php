<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Contracts\View\View;

class ServiceCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', 10);
        $data = ServiceCategory::paginate($perPage);

        return view('service-management.service-category-index',compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|string',
        ]);

        ServiceCategory::create($validated);
        return redirect()->back()->with('success', 'Service category created successfully.');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $service = ServiceCategory::findOrFail($id);
        $service->update($validated);

        return redirect()->back()->with('success', 'Service category updated successfully.');
    }

    public function destroy( $id)
    {
        $service = ServiceCategory::find($id);
        $service->delete();
        return redirect()->back()->with('success', 'Service category deleted!');
    }
}
