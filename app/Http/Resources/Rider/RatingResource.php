<?php

namespace App\Http\Resources\Rider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'rating' => (float)$this->rating,
             'driver_id' => $this->driver_id,
             'rider_id' => $this->rider_id,
             'comment' => $this->comment

        ];
    }
}
