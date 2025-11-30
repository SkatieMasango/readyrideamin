<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ServiceOption;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ServiceOptionController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->query('per_page', 10);
        $data = ServiceOption::paginate($perPage);

        return view('service-management.service-option-index', compact('data'));
    }

    public function create(): View
    {
        return view('services-option.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable',
            'additional_fee' => 'required_if:type,cash,two_way|nullable|numeric',
        ],
        [
            'additional_fee.required_if' => 'Additional fee is required for cash or two way services.',
        ]);
        ServiceOption::create($validated);

        return redirect()->route('services-option.index')->with('success', 'Service option created successfully.');
    }

    public function edit($id): View
    {
        $serviceOption = ServiceOption::find($id);

        return view('services-option.edit', compact('serviceOption'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable',
            'additional_fee' => 'required_if:type,cash,two_way|nullable|numeric',
        ],
        [
            'additional_fee.required_if' => 'Additional fee is required for cash or two way services.',
        ]);

        $service = ServiceOption::findOrFail($id);
        $service->update($validated);

        return redirect()->route('services-option.index')->with('success', 'Service option updated successfully.');
    }

    public function destroy( $id)
    {
        $service = ServiceOption::find($id);
        $service->delete();
        return redirect()->route('services-option.index')->with('success', 'Service option deleted!');
    }
}
