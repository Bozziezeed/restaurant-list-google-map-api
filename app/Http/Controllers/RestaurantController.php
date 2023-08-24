<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');


        // Try to retrieve cached results first
        $cachedResults = Cache::get('search:' . $keyword);
        if ($cachedResults) {
            Log::info("cache cached results:", $cachedResults);
            return response()->json($cachedResults);
        }

        // Create the getLocationUrl
        $getLocationUrl = 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?' . http_build_query([
            "fields" => "formatted_address,name,geometry",
            'input' => $keyword,
            'inputtype' => "textquery",
            'key' => config('app.GOOGLE_MAPS_API_KEY'),
        ]);


        // Send the HTTP responseLocation
        $responseLocation = Http::get($getLocationUrl);

        $keywordResult = $responseLocation->json();
        // Log::info('Google Maps API Response:', $keywordResult); // Add this line to log the data

        $keywordLocation = null;
        if (isset($keywordResult['candidates'][0]['geometry']['location'])) {
            $location = $keywordResult['candidates'][0]['geometry']['location'];
            $lat = $location['lat'];
            $lng = $location['lng'];

            $keywordLocation = (object) [
                "lat" => $lat,
                "lng" => $lng
            ];
        }
        // Log::info('keywordLocation:', (array) $keywordLocation);


        // Create the findRestaurantUrl
        $findRestaurantUrl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?' . http_build_query([
            "location" => $keywordLocation->lat . ',' . $keywordLocation->lng,
            'radius' => 1500,
            'type' => "restaurant",
            'key' => config('app.GOOGLE_MAPS_API_KEY'),
        ]);
        // Log::info('Google Maps API Request URL:', ['url' => $findRestaurantUrl]);

        // Send the HTTP responseRestaurant
        $responseRestaurant = Http::get($findRestaurantUrl);

        $restaurantResult = $responseRestaurant->json();
        Log::info('Google Maps API Response:', $restaurantResult);

        if (isset($restaurantResult['results'])) {
            foreach ($restaurantResult['results'] as $result) {
                $location = $result['geometry']['location'];

                $restaurant = [
                    'name' => $result['name'],
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                ];

                if (isset($result['vicinity'])) {
                    $restaurant['address'] = $result['vicinity'];
                }

                $restaurants[] = $restaurant;
            }
        }
        Log::info("restaurants : ", $restaurants);



        //cache restaurants & keyword before return
        Cache::put('search:' . $keyword, $restaurants, now()->addHours(1));

        // Return the extracted restaurant data
        return response()->json($restaurants);
    }
}
