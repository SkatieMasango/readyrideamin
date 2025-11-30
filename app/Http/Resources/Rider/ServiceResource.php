<?php

namespace App\Http\Resources\Rider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'name' => $this->name,
            'logo' => $this->servicePicture,
            'person_capacity' => $this->person_capacity,
            'minimum_fee' => (float) number_format($this->minimum_fee, 2),
            'base_fare' => (float) number_format($this->base_fare, 2),
            'per_hundred_meters' => (float) number_format($this->per_hundred_meters, 2),
        ];
    }

}
