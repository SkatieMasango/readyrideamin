<?php

namespace App\Services;

class GoogleService
{
    public static function getDistanceAndDuration($pickupLat, $pickupLng, $dropoffLat, $dropoffLng): array
    {
        $apiKey = env('GOOGLE_MAP_KEY');


        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$pickupLat,$pickupLng&destinations=$dropoffLat,$dropoffLng&key=$apiKey";
        $response = file_get_contents($url);

        $data = json_decode($response, true);


        if (! empty($data['rows'][0]['elements'][0]['status']) && $data['rows'][0]['elements'][0]['status'] == 'OK') {
            return [
                'origin' => $data['origin_addresses'][0],
                'destination' => $data['destination_addresses'][0],
                'distanceText' => $data['rows'][0]['elements'][0]['distance']['text'],
                'distance' => $data['rows'][0]['elements'][0]['distance']['value'],
                'durationText' => $data['rows'][0]['elements'][0]['duration']['text'],
                'duration' => $data['rows'][0]['elements'][0]['duration']['value'],
            ];
        }

        return [];
    }

    public static function getDirections($origin, $destination): array
    {
        $origin = urlencode(implode(',', $origin));
        $destination = urlencode(implode(',', $destination));

        $apiKey = env('GOOGLE_MAP_KEY');
        $url = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$origin.'&destination='.$destination.'&key='.$apiKey;

        // TODO To avoid tolls or highways
        if (false) {
            $url .= '&avoid=tolls|highways';
        }
        // TODO optimize waypoints (multiple stops)
        if (false) {
            $url .= '&waypoints=optimize:true|lat,lng|lat,lng';
        }

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if ($data['status'] == 'OK') {
            $route = $data['routes'][0]['legs'][0];

            return [
                'distance' => $route['distance']['text'],  // e.g., "10 km"
                'duration' => $route['duration']['text'],  // e.g., "15 mins"
                'polyline' => $data['routes'][0]['overview_polyline']['points'], // Encoded route for drawing on map
            ];
        }

        return [];
    }


    public static function geocodeAddress($address): ?array
{

    $apiKey = env('GOOGLE_MAP_KEY');
    $encodedAddress = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$encodedAddress&key=$apiKey";

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['status'] === 'OK') {
        $location = $data['results'][0]['geometry']['location'];
        return [
            'lat' => $location['lat'],
            'lng' => $location['lng'],
        ];
    }

    return null;
}

}
