<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SOS;
use App\Models\SOSActivity;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SosController extends Controller
{
    public function index(): View
    {
        $sosList = SOS::all();

        return view('sos.index', compact('sosList'));
    }
     public function show($id): View
    {
        $sos = SOS::find($id);
        $sosActivites = SOSActivity::where('sos_id', $id)->get();

        return view('sos.show', compact('sos','sosActivites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_id' => 'nullable|exists:orders,id',
        ]);

        $request = Order::find($validated['request_id']);
        $currentLocation = json_decode($request->driver->current_location, true);
        $lat = $currentLocation['lat'] ?? null;
        $lng = $currentLocation['lng'] ?? null;

        $sos = SOS::create([
            'status' => 'submitted',
            'location' => [
                'lat' => $lat,
                'lng' => $lng,
            ],
            'request_id' => $validated['request_id'],
            'submitted_by_rider' => auth()->user()->roles[0]->name === 'rider' ? true : false,
        ]);

        return successResponse([
                'sos' => $sos,
            ]);
    }

    public function saveActiviey(Request $request)
    {
        $request->validate([
            'action' => 'required|string',
            'note' => 'nullable|string',
            'sos_id' => 'required|exists:sos,id',
        ]);

        $activity = SOSActivity::create([
            'status' => $request->action,
            'note' => $request->note,
            'sos_id' => $request->sos_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Activity saved successfully.',
            'data' => $activity,
        ]);

    }

}
