<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ComplaintControllerWeb extends Controller
{
    public function index(Request $request): View
    {
        $search   = $request->input('search');
        $perPage = $request->query('per_page', 10);

        $data = Complaint::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->where('status', 'like', "%{$search}%")
                ->orWhere('complaint_by', 'like', "%{$search}%");
            })->paginate($perPage);

        return view('complaints.index',compact('data'));

    }

    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::find($id);
        $complaint->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status updated successfully!');
    }

}
