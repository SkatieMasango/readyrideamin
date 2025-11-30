<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegionRequest;
use App\Models\Currency;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::paginate(perPage: 10, page: 1);

        return view('regions.index', ['regions' => $regions]);
    }

    public function create()
    {
        $currencies = Currency::query()
            ->select('country', 'currency_code')
            ->get()
            ->map(fn ($currency) => [
                'name' => $currency->country,
                'value' => $currency->currency_code,
            ])
            ->toArray();

        return view('regions.create', ['currencies' => $currencies]);
    }

    public function store(RegionRequest $request)
    {
        $polygonCoordinatesJson = $request->input('polygon_coordinates'); // JSON string
        $polygonCoordinatesArray = json_decode($polygonCoordinatesJson, true);

       Region::create([
            'name' => $request->name,
            'currency' => $request->currency,
            'is_active' => $request->is_enabled,
            'polygon_coordinates' => json_encode($polygonCoordinatesArray), // save as JSON string
        ]);

        return redirect()->route('regions.index')->with('success', 'Region created successfully!');
    }

        public function edit($id)
    {
        $region = Region::findOrFail($id);

        $currencies = Currency::query()
            ->select('country', 'currency_code')
            ->get()
            ->map(fn ($currency) => [
                'name' => $currency->country,
                'value' => $currency->currency_code,
            ])
            ->toArray();

        return view('regions.edit', ['currencies' => $currencies, 'region' => $region]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'currency' => 'required|string',
            'is_enabled' => 'required|boolean',
            'polygon_coordinates' => 'nullable|string', // JSON string
        ]);

        $region = Region::findOrFail($id);

        $polygonCoordinatesJson = $request->input('polygon_coordinates'); // JSON string
        $polygonCoordinatesArray = json_decode($polygonCoordinatesJson, true);

       $region->update([
            'name' => $request->name,
            'currency' => $request->currency,
            'is_active' => $request->is_enabled,
        ]);

        if($polygonCoordinatesArray != null){
            $region->polygon_coordinates = json_encode($polygonCoordinatesArray);
            $region->save();
        }

        return redirect()->back()->with('success', 'Region updated successfully!');
    }

       public function destroy($id)
    {
        $region = Region::find($id);
        $region->delete();
        return redirect()->route('regions.index')->with('success', 'Region deleted!');
    }
}
