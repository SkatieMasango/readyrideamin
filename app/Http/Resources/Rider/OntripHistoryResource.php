<?php

namespace App\Http\Resources\Rider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OntripHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_on' => $this->created_on,
            'distance_best' => $this->distance_best * 1000,
            'duration_best' => $this->duration_best *60,
            'wait_minutes' => $this->wait_minutes,
            'wait_cost' => $this->wait_cost,
            'ride_options_cost' => $this->ride_options_cost,
            'tax_cost' => $this->tax_cost,
            'service_cost' => $this->service_cost,
            'points' => json_decode($this->points),
            'addresses' => json_decode($this->addresses),
            'expected_timestamp' => $this->expected_timestamp,
            'driver_last_seen_messages_at' => $this->driver_last_seen_messages_at,
            'rider_last_seen_messages_at' => $this->rider_last_seen_messages_at,
            'destination_arrived_to' => $this->destination_arrived_to,
            'start_timestamp' => $this->start_timestamp,
            'finish_timestamp' => $this->finish_timestamp,
            'rider' => $this->when($this->rider_id, function () {
                return [
                    'id' => $this->rider?->user?->id,
                    'name' => $this->rider?->user?->name,
                    'email' => $this->rider?->user?->email,
                    'mobile' => $this->rider?->user?->mobile,
                    'profile_picture' => $this->rider?->user?->profile_picture,
                ];
            }, null),
            'driver' => $this->when($this->driver_id, function () {
                return [
                    'id' => $this->driver?->user?->id,
                    'name' => $this->driver?->user?->name,
                    'email' => $this->driver?->user?->email,
                    'mobile' => $this->driver?->user?->mobile,
                    'rating' => $this->driver?->rating ?? 0,
                    'profile_picture' => $this->driver?->user?->profile_picture,
                    'direction' => $this->driver?->heading ?? 0,
                ];
            }, null),
            'cost_after_coupon' => (string) $this->cost_after_coupon,
            'payment_mode' => $this->payment_mode,
            'payment_gateway_id' => $this->payment_gateway_id,
            'payment_method_id' => $this->payment_method_id,
            'eta_pickup' => $this->eta_pickup,
            'cost_best' => (string) $this->cost_best,
            'paid_amount' => $this->paid_amount,
            'tip_amount' => $this->tip_amount,
            'provider_share' => $this->provider_share,
            'currency' => $this->currency,
            'directions' => $this->directions,
            'service' => new ServiceResource($this->whenLoaded('service')),
            'service' => $this->when($this->service_id, function () {
                return new ServiceResource($this->service);
            }, null),

            'vehicle' => $this->when($this->driver_id, function () {
                return [
                    'id' => $this->driver?->user?->id,
                    'vehicleColor' => $this->driver?->vehicleColor?->name,
                    'vehicleModel' => $this->driver?->vehicle?->name,
                    'vehiclePlateNumber' => $this->driver?->vehicle_plate,
                    'vehicleProductionYear' => $this->driver?->vehicle_production_year,
                    // 'profile_picture' => $this->driver?->user?->profile_picture,
                    'direction' => $this->driver?->heading ?? 0,
                ];
            }, null),
        ];
    }
}
