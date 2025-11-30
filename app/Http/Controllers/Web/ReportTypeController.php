<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ReportType;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $perPage = $request->query('per_page', 10);

        $data = ReportType::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->where('status', 'like', "%{$search}%")
                ->orWhere('complaint_by', 'like', "%{$search}%");
            })->paginate($perPage);

        return view('report-types.index',compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string|max:255',

        ]);
        ReportType::create([
            'report_type' => $request->report_type,
        ]);

        return redirect()->route('report-types.index')->with('success', 'Report created successfully.');

    }

    public function destroy($id)
    {
        $report = ReportType::find($id);
        $report->delete();
        return redirect()->route('report-types.index')->with('success', 'Report deleted!');
    }


}
