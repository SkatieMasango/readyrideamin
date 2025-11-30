<?php

namespace App\Http\Resources\Rider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'max_users' => $this->max_users, // 0 means unlimited users can use it
            'max_uses_per_user' => $this->max_uses_per_user, // 1 means each user can use it once
            'minimum_cost' => (float) number_format($this->minimum_cost, 2),
            'maximum_cost' => (float) number_format($this->maximum_cost, 2),
            'valid_from' => $this->valid_from->format('Y-m-d H:i:s'),
            'valid_till' => $this->valid_till->format('Y-m-d H:i:s'),
            'discount_percent' => (float) number_format($this->discount_percent, 2),
            'discount_flat' => $this->discount_flat,
            'credit_gift' => $this->credit_gift,
            'is_enabled' => (bool) $this->is_enabled,
            'is_first_travel_only' => (bool) $this->is_first_travel_only,
        ];
    }
}
