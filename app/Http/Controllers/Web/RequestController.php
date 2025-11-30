<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class RequestController extends Controller
{
     public function index(Request $request)
    {
        $search   = $request->input('search');
        $joinDate = $request->input('join_date');
        $orderBy  = $request->input('order_by');
        $perPage = $request->query('per_page', 10);

        $requests = Order::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(function ($subQuery) use ($search) {
                        $subQuery->whereHas('rider.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('driver.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->when($joinDate, function ($query) use ($joinDate) {
                [$startDate, $endDate] = explode(' to ', $joinDate);
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            })
            ->orderBy('created_at', $orderBy === 'oldest' ? 'asc' : 'desc')
            ->paginate($perPage);


        return view('requests.index', [
            'data' => $requests,
        ]);


    }

     public function show($id): View
    {
        $request = Order::find($id);
        $transactions = TransactionRepository::query()->where('order_id', $request->id) ->get();
        return view('requests.show', compact('request','transactions'));
    }
     public function generateExport(Request $request)
    {
        $search = $request->query('search');
        $joinDate = $request->query('join_date');
        $orderBy = $request->query('order_by');
        $page_num = $request->query('page', 1);
        $exportType = $request->query('export_type');

        $orders = OrderRepository::query()
            ->when($search && is_string($search), function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(function ($subQuery) use ($search) {
                        $subQuery->whereHas('rider.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('driver.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->orWhere('id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->when($joinDate, function ($query) use ($joinDate) {
                [$startDate, $endDate] = explode(' to ', $joinDate);
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            })
            ->orderBy('created_at', $orderBy === 'oldest' ? 'asc' : 'desc')
            ->withTrashed()
            ->paginate(10, ['*'], 'page', $page_num);

        $data = $orders->items();

        $csvContent = "SL,Date,Rider,Driver,Service,Status\n";

        foreach ($data as $index => $report) {
            $csvContent .= implode(',', [
                $index + 1,
                $report->created_at,
                $report->rider?->user?->name ?? 'N/A',
                $report->driver?->user?->name ?? 'N/A',
                $report->service->name ?? 'N/A',
                $report->status->value ?? 'N/A',
            ]) . "\n";
        }

        if ($exportType === 'pdf') {
            $pdf = Pdf::loadView('requests.orderPdf', [
                'orders' => $data,
                'page_num' => $page_num,
            ]);
            return $pdf->stream("report-{$page_num}.pdf");
        }
        else{
            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="report.csv"');
        }

        return redirect()->back()->with('error', 'Invalid export type selected.');
    }
}
