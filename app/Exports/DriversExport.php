<?php

namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;

class DriversExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Driver::with('user', 'orders')
            ->get()
            ->map(function ($driver) {
                return [
                    'Mobile' => $driver->user?->mobile,
                    'Name' => $driver->user?->name,
                    'Registered On' => \Carbon\Carbon::parse($driver->created_at)->diffForHumans(),
                    'Address' => $driver->user?->address,
                    'Order Count' => count($driver->orders ?? []),
                    'Status' => $driver->user?->status?->label(),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Mobile',
            'Name',
            'Registered On',
            'Address',
            'Order Count',
            'Status',
        ];
    }
}
