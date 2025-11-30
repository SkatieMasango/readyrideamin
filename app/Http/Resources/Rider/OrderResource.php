<?php

namespace App\Http\Resources\Rider;

use App\Models\ServiceOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

    //    ServiceOption::query()->get(['id as value', 'name']),
        return [
            'id' => $this->id,
            'status' => $this->status,
            'distance' => $this->distance_best * 1000,
            'duration' => $this->duration_best * 60,
            'wait_minutes' => $this->wait_minutes,
            'points' => json_decode($this->points),
            'addresses' => json_decode($this->addresses),
            'order_time' => $this->created_at,
            'start_timestamp' => $this->start_timestamp,
            'finish_timestamp' => $this->finish_timestamp,
            'pay_method' => $this->payment_mode,
            'payment_status' => $this->payment_status,
            'pickup_at' => $this->pickup_at,
            'sub_total' => (double) number_format($this->cost_best, 2),
            'discount' => (double) number_format($this->cost_after_coupon == 0 ? $this->cost_after_coupon : $this->cost_best - $this->cost_after_coupon, 2),
            'payable_amount' => (double) number_format($this->cost_after_coupon == 0 ? $this->cost_best : $this->cost_after_coupon, 2),
            'currency' => $this->currency,
            'directions' => $this->directions,
            'rating' => $this->ratings[0]->rating ?? 0,
            'service' => new ServiceResource($this->whenLoaded('service')),
            'service' => $this->when($this->service_id, function () {
                return new ServiceResource($this->service);
            }, null),
            'ride_preferences' => $this->when($this->serviceOptions, function (){
                return ServiceOptionResource::collection($this->serviceOptions);
            }),
            'driver' => $this->when($this->driver_id, function () {
                return [
                    'id' => $this->driver?->user?->id,
                    'name' => $this->driver?->user?->name,
                    'email' => $this->driver?->user?->email,
                    'mobile' => $this->driver?->user?->mobile,
                    'profile_picture' => $this->driver?->user?->profile_picture,
                    'rating' => $this->driver?->rating ?? 0,
                    'direction' => $this->driver?->heading ?? 0,
                    'current_location' => json_decode($this->driver?->current_location) ?? null,
                    'total_trip' => (int) $this->driver?->orders()->where('status', 'completed')->count(),

                ];
            }, null),
            'rider' => $this->when($this->rider_id, function () {
                return [
                    'id' => $this->rider?->user?->id,
                    'name' => $this->rider?->user?->name,
                    'email' => $this->rider?->user?->email,
                    'mobile' => $this->rider?->user?->mobile,
                    'profile_picture' => $this->rider?->user?->profile_picture,
                    'on_trip' => (bool)$this->rider?->on_trip ?? 0,
                    'total_trip' => (int) $this->rider?->orders()->where('status', 'completed')->count(),
                    'rating' => $this->ratings[0]->rating ?? 0,
                    // 'rating' => $this->rider?->rating ?? 0
                ];
            }, null),
            'vehicle' => $this->when($this->driver_id, function () {
                return [
                    'id' => $this->driver?->user?->id,
                    'vehicleColor' => $this->driver?->vehicleColor?->name,
                    'vehicleModel' => $this->driver?->vehicle?->name,
                    'vehiclePlateNumber' => $this->driver?->vehicle_plate,
                    'vehicleProductionYear' => $this->driver?->vehicle_production_year,
                    'direction' => $this->driver?->heading ?? 0,
                ];
            }, null),
        ];
    }
}
