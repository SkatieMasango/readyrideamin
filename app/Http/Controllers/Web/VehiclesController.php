<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use App\Models\VehicleColor;
use App\Models\VehicleModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function indexCategory(): View
    {
        $vehicleCategory = VehicleCategory::query()->paginate(15);
        return view('vehicles.category-index', compact(['vehicleCategory']));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        VehicleCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Vehicle category added successfully.');
    }
    public function destroyCategory($id)
    {
        $vehicleCategory = VehicleCategory::find($id);
        $vehicleCategory->delete();
        return redirect()->back()->with('success', 'Vehicle category deleted successfully.');
    }

    public function indexBrand(): View
    {
        $vehicleBrands = VehicleBrand::query()->paginate(15);
        $vehicleCategory = VehicleCategory::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' => $id,
            'name' => $name,
        ])->values()->toArray();

        return view('vehicles.brand-index', compact(['vehicleBrands','vehicleCategory']));
    }
    public function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'vehicle_category_id' => 'required',
        ]);
        VehicleBrand::create([
            'name' => $request->name,
            'vehicle_category_id' => $request->vehicle_category_id
        ]);

        return redirect()->back()->with('success', 'Vehicle brand added successfully.');
    }

    public function destroyBrand($id)
    {
        $vehicleBrand = VehicleBrand::find($id);
        $vehicleBrand->delete();
        return redirect()->back()->with('success', 'Vehicle brand deleted successfully.');
    }

    public function indexModel(): View
    {
        $vehicleModels= VehicleModel::all();
        $vehicleBrands = VehicleBrand::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' => $id,
            'name' => $name,
        ])->values()->toArray();

        return view('vehicles.model-index', compact(['vehicleBrands','vehicleModels']));
    }
    public function storeModel(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'vehicle_brand_id' => 'required',
        ]);
        VehicleModel::create([
            'name' => $request->name,
            'vehicle_brand_id' => $request->vehicle_brand_id
        ]);
        return redirect()->back()->with('success', 'Vehicle model added successfully.');
    }

    public function destroyModel($id)
    {
        $vehicleModel = VehicleModel::find($id);
        $vehicleModel->delete();
        return redirect()->back()->with('success', 'Vehicle model deleted successfully.');
    }

    public function indexColor(): View
    {
        $vehicleColors= VehicleColor::query()->paginate(15);
        return view('vehicles.color-index', compact(['vehicleColors']));
    }
    public function storeColor(Request $request)
    {
            $request->validate([
                'name' => 'required',
            ]);
            VehicleColor::create([
                'name' => $request->name,
            ]);
            return redirect()->back()->with('success', 'Vehicle color added successfully.');
        }

    public function destroyColor($id)
    {
        $vehicleColor = VehicleColor::find($id);
        $vehicleColor->delete();
        return redirect()->back()->with('success', 'Vehicle color deleted successfully.');
    }
}
