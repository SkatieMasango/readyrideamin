<?php

namespace App\Http\Resources;

use App\Enums\OrderStatus;
use App\Enums\Status;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data = [
            "id" => $this->id,
            "name" => $this->name,
            "country_iso"=> $this->country_iso,
            "gender" => $this->gender,
            "address" => $this->address,
            "email" => $this->email,
            "mobile" => $this->mobile,
            "email_verified" => $this->email_verified_at ? true : false,
            "otp_verified" => $this->otp_verified_at ? true : false,
            "status" => $this->status,
            "profile_picture" => $this->profilePicture,
            'device_toekn' => $this->device_token
        ];

        if($this->driver){
            $data = array_merge($data, $this->getDriver());
        }

        return $data;
    }


    private function getDriver(): array
    {
        $totalRide = Order::where('driver_id', $this->driver->id)->where('status', OrderStatus::COMPLETED)->count();
        $totalDistanceInMeters = Order::where('driver_id', $this->driver->id)->where('status', OrderStatus::COMPLETED)->sum('distance_best');
        $totalDistanceInKm = round($totalDistanceInMeters , 2);

        return [
            "emergency_contact" => $this->driver->emergency_contact,
            "vehicle_color" => $this->driver->vehicle_color_legacy,
            'vehicle_regi_year' => $this->driver->vehicle_production_year,
            'vehicle_plate' => $this->driver->vehicle_plate,
            'rating' => (float) number_format($this->driver->rating ?? 0.0, 1),
            'review_count' => (int) $this->driver->ratings->count(),
            'is_under_review' => $this->isNew || $this->status != Status::PENDING_APPROVAL ? true : false,
            'radius_in_meter' => (int) $this->driver->radius_in_meter,
            'driver_status' => $this->driver->driver_status,
            'total_ride' => (int) $totalRide,
            'total_distance' => (float) number_format($totalDistanceInKm, 2),
            'documents' => [
                'nid' => $this->nidPicture ?? null,
                'license' => $this->licensePicture ?? null,
                'vehicle_paper' => $this->ownershipPicture ?? null,
            ],

        ];
    }
}
