<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'order_id' => $this->order_id,
            'transaction' => $this->transaction,
            'amount' => (float) number_format($this->amount, 2),
            'method' => $this->method,
            'created_at' => $this->created_at->format('F j, Y g:i A'),
        ];
    }

}
