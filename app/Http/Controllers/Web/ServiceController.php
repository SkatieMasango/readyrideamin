<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Repositories\MediaRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $search   = $request->input('search');
        $perPage = $request->query('per_page', 10);

        $data = Service::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })->paginate($perPage);

        return view('service-management.service-index',compact('data'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): View
    {
        $serviceCategory = serviceCategory::query()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' => $id,
            'name' => $name,
        ])->values()->toArray();
        return view('service-management.service-create',compact('serviceCategory'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'person_capacity' => 'nullable|integer',
            'fare' => 'nullable|numeric',
            'base_fare' => 'required|numeric',
            'per_hundred_meters' => 'required|numeric',
            'over_minutes' => 'nullable|integer',
            'per_minute_drive' => 'required|numeric',
            'per_minute_wait' => 'nullable|numeric',
            'minimum_fee' => 'required|numeric',
            'two_way_available' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $service = Service::create($validated);
        MediaRepository::storeByRequest($request->file('image'), '/service_image', 'service_picture', $service);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function edit($id): View
    {
        $service = Service::find($id);
        $serviceCategory = serviceCategory::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' => $id,
            'name' => $name,
        ])->values()->toArray();

        return view('service-management.service-edit', compact('service','serviceCategory'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'name' => 'required|max:255',
            'description' => 'nullable|string',
            'person_capacity' => 'nullable|integer',
            'fare' => 'nullable|numeric',
            'base_fare' => 'required|numeric',
            'per_hundred_meters' => 'required|numeric',
            'over_minutes' => 'nullable|integer',
            'per_minute_drive' => 'required|numeric',
            'per_minute_wait' => 'nullable|numeric',
            'minimum_fee' => 'required|numeric',
            'two_way_available' => 'nullable',
        ]);

        $service = Service::findOrFail($id);
        $service->update($validated);

        if($request->file('image')){
            $existingDocument = $service->servicePicture()->where('type', 'service_picture')->first();

            if($existingDocument){
                Storage::disk('public')->delete($existingDocument->path);
                $existingDocument->delete();
            }
            MediaRepository::storeByRequest($request->file('image'), '/service_image', 'service_picture', $service);
        }

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy( $id)
    {
        $service = Service::find($id);
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted!');
    }

}
