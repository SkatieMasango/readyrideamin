<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'email' => $this->email,
            'mobile' => $this->mobile,
            'gender' => (string) $this->gender,
            'profile_picture' => $this->profile_picture,
            'driver_licence' => $this?->driver?->driver_licence,
            'driver_status' => $this?->driver?->driver_status,
            'radius_in_meter' => $this?->driver?->radius_in_meter,
            'vehicle' => [
                'id' => $this->driver?->vehicle?->id,
                'name' => $this->driver?->vehicle?->name,
                'color' => [
                    'id' => $this->driver?->vehicleColor?->id,
                    'name' => $this->driver?->vehicleColor?->name,
                ],
                'production_year' => $this->driver?->vehicle_production_year,
                'vehicle_plate' => $this->driver?->vehicle_plate,
            ],
            'bank' => [
                'account_number' => $this->driver?->account_number,
                'name' => $this->driver?->bank_name,
                'routing_number' => $this->driver?->bank_routing_number,
                'swift' => $this->driver?->bank_swift,
            ],
            'documents' => [
                'profile_picture' => $this->getDocumentUrls('profile_picture')[0] ?? null,
                'documents' => $this->getDocumentUrls('documents') ?? null,
            ],
        ];
    }

    private function getDocumentUrls(string $type): ?array
    {
        $documents = optional($this->documents())->where('type', $type)->get() ?? collect();
        if ($documents->isEmpty()) {
            return null;
        }

        return $documents->map(fn ($document) => asset('storage/'.$document->path))->toArray();
    }
}
