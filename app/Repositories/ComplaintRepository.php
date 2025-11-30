<?php
namespace App\Repositories;

use App\Models\Complaint;
use App\Enums\ComplaintStatus;
use Illuminate\Support\Facades\Auth;
use Abedin\Maker\Repositories\Repository;

class ComplaintRepository extends Repository
{
    public static function model()
    {
        return Complaint::class;
    }
    /**
     * Store a new complaint based on the request data.
     *
     * @param \Illuminate\Http\Request $request
     * @return Complaint
     */
    public static function storByRequest($request)
    {
        $order= OrderRepository::find($request->order_id);
        $user = Auth::user();
        $role = $user->getRoleNames();

        return self::create([
            'request_id' => $request->order_id,
            'rider_id'   => $order->rider_id,
            'driver_id' => $order->driver_id,
            'report_type'   => $request->report_type,
            'note' => $request->note,
            'status' => ComplaintStatus::UNDER_INVESTIGATION,
            'complaint_by'   => $role[0] === 'rider' ? true : false,
        ]);

    }

    public static function getComplaintsWithStatus($status){
        return self::query()->where('status', $status)->get();
}
}
