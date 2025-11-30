<?php

namespace App\Http\Controllers\API\Rider;

use App\Http\Controllers\Controller;
use App\Models\Promotional;
use Illuminate\Http\Request;

class PromotionalController extends Controller
{
    public function index(){
            $promos = Promotional::with('media')->get()->map(function ($method) {
            return [
                'id' => $method->id,
                'image' => $method->media()->first()->url,
            ];
        });

        return $this->json(message: 'Slider list!', data:  $promos);
    }
}
