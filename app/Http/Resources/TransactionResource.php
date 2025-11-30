<?php

namespace App\Http\Resources;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray(Request $request): array
{

    $withdraw = Withdraw::where('transaction_id', $this->id)->first();
    return [
        'id'         => $this->id,
        'order_id'   => $this->order_id,
        'rider' => $this->when($this->rider_id, function () {
                return [
                    'id' => $this->rider?->user?->id,
                    'name' => $this->rider?->user?->name,
                    'profile_picture' => $this->rider?->user?->profile_picture,
                ];
            }, null),

        'driver_id'  => $this->driver_id,
        'transaction'=> $this->transaction,
        'amount' => (float) number_format($this->amount, 2),
        'method'     => $this->method,
        'payment_mode' => $this->payment_mode,
        'created_at' => $this->created_at,
        'withdraw_history' => $this->payment_mode === 'withdraw'
            ?  new WithdrawResource($withdraw)
            : null,
    ];
}

}

