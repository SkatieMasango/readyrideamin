<?php

namespace App\Http\Controllers\API\Driver;

use App\Http\Controllers\Controller;
use App\Models\ReportType;

class ReportController extends Controller
{

    public function getTypes(){

        $reportTypes = ReportType::select('report_type')->get();

        return $this->json('All available report types', [
            'types' => $reportTypes,
        ]);
    }
}
