<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = $this['status'];
        $statusOptions = \App\Enums\ComplaintStatus::options();

        return [
            "id"=> $this->id,
            "request_id"=> (int)$this->request_id,
            "rider_id"=> $this->rider_id,
            "driver_id"=> $this->driver_id,
            "report_type"=> $this->report_type,
            "note"=> $this->note,
            "status"=> (string) $statusOptions[$status->value]['name'] ?? ucfirst($status->value),
            "complaint_by"=> $this->complaint_by ,
        ];
    }
}
