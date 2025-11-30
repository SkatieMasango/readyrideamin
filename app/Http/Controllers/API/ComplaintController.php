<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComplaintResource;
use App\Repositories\ComplaintRepository;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function createReport(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'report_type' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $report = ComplaintRepository::storByRequest($request);

        return $this->json('Report create successfully', [
                   'Report' => new ComplaintResource($report),
        ]);

    }
}
