<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class ProductsController extends Controller
{
    public function test($slug = null)
    {
        $apiKey = env('AIRTABLE_KEY');
        $baseId = env('AIRTABLE_BASE_ID');
        $tableIDproducts = env('AIRTABLE_TABLE_ID_PRODUCTS');
        $tableIDhotels = env('AIRTABLE_TABLE_ID_HOTELS');
        $tableIDitineraries = env('AIRTABLE_TABLE_ID_ITINERARIES');

        // Fetch Product Start
        $responseProducts = Http::withHeaders(['Authorization' => 'Bearer '.$apiKey])
            ->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableIDproducts.'?filterByFormula=SEARCH(%22'.$slug.'%22%2C+%7Bslug%7D)');
        $products = json_decode($responseProducts, true)['records'];

        // return response($products);
        // Fetch Product End

        if ($products == null) {
            return [
                'code' => '204',
                'error' => 'Package Not Found',
            ];
        }

        // Restructure product start
        foreach ($products as $pd) {
            // Restructure departure start
            $transformDPT = [];
            for ($i = 0; $i < count($pd['fields']['flightDeparture']); ++$i) {
                $transformDPT[] = [
                    'airportDepartureName' => $pd['fields']['airportDepartureName'][$i],
                    'airportDepartureCode' => $pd['fields']['airportDepartureCode'][$i],
                ];
            }
            $resultDPT = $transformDPT;
            // Restructure departure end
            // Restructure arrival start
            $transformRTN = [];
            for ($i = 0; $i < count($pd['fields']['flightReturn']); ++$i) {
                $transformRTN[] = [
                    'airportReturnName' => $pd['fields']['airportReturnName'][$i],
                    'airportReturnCode' => $pd['fields']['airportReturnCode'][$i],
                ];
            }
            $resultRTN = $transformRTN;
            // Restructure arrival end
            // Restructure price start
            $price = [
                'priceNormal' => $pd['fields']['priceNormal'],
                'priceDiscount' => $pd['fields']['priceDiscount'],
            ];
            // Restructure price end
            // Restructure airlines start
            $airlines = [
                'airlinesIcon' => $pd['fields']['airlinesIcon'][0]['url'],
                'airlinesCode' => $pd['fields']['airlinesCode'][0],
                'airlinesName' => $pd['fields']['airlinesName'][0],
            ];
            // Restructure airlines end
            $transProduct = [
                'id' => $pd['id'],
                'slug' => $pd['fields']['slug'],
                'thumbnail' => $pd['fields']['thumbnail'][0]['url'],
                'name' => $pd['fields']['name'],
                'airlines' => $airlines,
                'flightDeparture' => $resultDPT,
                'flightReturn' => $resultRTN,
                'hotel' => $pd['fields']['hotel'],
                'itinerary' => $pd['fields']['itinerary'],
                'price' => $price,
            ];
            $simpleProduct[] = $transProduct;
        }
        $products = $simpleProduct;

        // return response($products);
        // Restructure product end

        // Fetch Hotel Start
        $responseHotels = Http::withHeaders(['Authorization' => 'Bearer '.$apiKey])
            ->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableIDhotels);

        $hotels = json_decode($responseHotels, true)['records'];

        // return response($hotels);
        // Fetch Hotel End

        // Restructure hotel start
        foreach ($hotels as $ht) {
            // Restructure attraction start
            $transformedAttraction = [];
            for ($i = 0; $i < count($ht['fields']['attractionCategory']); ++$i) {
                $transformedAttraction[] = [
                    'attractionCategory' => isset($ht['fields']['attractionCategory'][$i]) ? $ht['fields']['attractionCategory'][$i] : [],
                    'attractionLocation' => isset($ht['fields']['attractionLocation'][$i]) ? $ht['fields']['attractionLocation'][$i] : [],
                    'attractionName' => isset($ht['fields']['attractionName'][$i]) ? $ht['fields']['attractionName'][$i] : [],
                ];
            }
            $resultAttraction = $transformedAttraction;
            // Restructure attraction end

            $transHotel = [
                'id' => $ht['id'],
                'thumbnail' => $ht['fields']['thumbnail'][0]['url'],
                'name' => $ht['fields']['name'],
                'star' => $ht['fields']['star'],
                'city' => $ht['fields']['city'],
                'masjid' => $ht['fields']['nearestMasjid'],
                'location' => $ht['fields']['location'],
                'attractions' => $resultAttraction,
            ];
            $simpleHotel[] = $transHotel;
        }
        $hotels = $simpleHotel;

        // return response($hotels);
        // Restructure hotel end

        // Fetch Itins Start
        $responseItins = Http::withHeaders(['Authorization' => 'Bearer '.$apiKey])
            ->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableIDitineraries);

        $itins = json_decode($responseItins, true)['records'];

        // return response($itins);
        // Fetch Itins End

        // Restructure itin start

        foreach ($itins as $itin) {
            $simplegal = [];
            foreach ($itin['fields']['gallery'] as $gal) {
                $simplegal[] = $gal['url'];
            }

            $transItin = [
                'id' => $itin['id'],
                'name' => $itin['fields']['name'],
                'description' => $itin['fields']['description'],
                'gallery' => $simplegal,
                'meal' => $itin['fields']['meal'],
            ];
            $simpleItin[] = $transItin;
        }
        $itins = $simpleItin;

        // return response($itins);

        // Restructure itin end

        // Mapping products with hotels start
        $products = array_map(function ($products) use ($hotels, $itins) {
            $hotelsMapped = [];
            foreach ($products['hotel'] as $prdHotels) {
                $recordHotel = collect($hotels)->firstWhere('id', $prdHotels);
                if ($recordHotel) {
                    $hotelsMapped[] = $recordHotel;
                }
            }

            $itinsMapped = [];
            foreach ($products['itinerary'] as $prdItins) {
                $recordItin = collect($itins)->firstWhere('id', $prdItins);
                if ($recordItin) {
                    $itinsMapped[] = $recordItin;
                }
            }

            return [
                'id' => $products['id'],
                'slug' => $products['slug'],
                'thumbnail' => $products['thumbnail'],
                'name' => $products['name'],
                'airlines' => $products['airlines'],
                'flightDeparture' => $products['flightDeparture'],
                'flightReturn' => $products['flightReturn'],
                'hotel' => $hotelsMapped,
                'itinerary' => $itinsMapped,
                'price' => $products['price'],
            ];
        }, $products);
        // return response($products);
        // Mapping produts with hotels end

        // return view('home', compact('products'));

        if ($slug != null) {
            return view('detail-product', compact('products'));
        } else {
            return view('home', compact('products'));
        }
    }

    public function urgent()
    {
        $apiKey = env('AIRTABLE_KEY');
        $baseId = env('AIRTABLE_BASE_ID');
        $tableUrgent = env('AIRTABLE_TABLE_URGENT');

        // Fetch and Transform Product Start
        $responseProducts = Http::withHeaders(['Authorization' => 'Bearer '.$apiKey])
            ->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableUrgent);

        $products = json_decode($responseProducts, true)['records'];

        // return response($products);

        return view('home-urgent', compact('products'));
    }

    public function index($slug = null)
    {
        $apiKey = env('AIRTABLE_KEY');
        $baseId = env('AIRTABLE_BASE_ID');
        $tableIDproducts = env('AIRTABLE_TABLE_ID_PRODUCTS');
        $tableIDitineraries = env('AIRTABLE_TABLE_ID_ITINERARIES');

        // Fetch and Transform Product Start
        $responseProducts = Http::withHeaders(['Authorization' => 'Bearer '.$apiKey])
            ->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableIDproducts.'?filterByFormula=SEARCH(%22'.$slug.'%22%2C+%7Bslug%7D)');

        $products = json_decode($responseProducts, true)['records'];
        // return response($products);

        if ($products == null) {
            return [
                'code' => '204',
                'error' => 'Package Not Found',
            ];
        }
        foreach ($products as $prd) {
            $simplegal = [];
            foreach ($prd['fields']['gallery'] as $gal) {
                $simplegal[] = $gal['url'];
            }
            $transprd = [
                'id' => $prd['id'],
                'slug' => $prd['fields']['slug'],
                'thumbnail' => $prd['fields']['thumbnail'][0]['thumbnails']['full']['url'],
                'gallery' => $simplegal,
                'name' => $prd['fields']['name'],
                'description' => $prd['fields']['description'],
                'includes' => $prd['fields']['includes'],
                'excludes' => $prd['fields']['excludes'],
                'price_normal' => $prd['fields']['price_normal'],
                'price_discount' => isset($prd['fields']['price_discount']) ? $prd['fields']['price_discount'] : null,
                'seat' => $prd['fields']['seat'],
                'seat_taken' => $prd['fields']['seat_taken'],
                'seat_left' => $prd['fields']['seat_left'],
                'seat_percentage' => $prd['fields']['seat_percentage'],
                'discount_percent' => $prd['fields']['discount_percent'],
                'duration' => count($prd['fields']['itineraries']),
                'airlines_icon' => $prd['fields']['airlinesIcon'][0]['url'],
                'airlines_name' => $prd['fields']['airlinesName'][0],
                'hotel_name' => array_values(array_unique($prd['fields']['hotelName'])),
                'itinerary' => $prd['fields']['itineraries'],
            ];
            $simpleprd[] = $transprd;
        }
        $products = $simpleprd;

        // return response($products);

        // Fetch and Transform Product End

        // Fetch and Transform Itineraries Start
        $respItins = Http::withHeaders([
            'Authorization' => 'Bearer '.$apiKey,
        ])->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableIDitineraries.'');
        $itins = json_decode($respItins, true)['records'];

        // return response($itins);

        foreach ($itins as $itin) {
            // Restructure Flight Schedule Start
            $flightData = [
                'airlinesIcon' => isset($itin['fields']['airlinesIcon']) ? $itin['fields']['airlinesIcon'] : [],
                'airlinesCode' => isset($itin['fields']['airlinesCode']) ? $itin['fields']['airlinesCode'] : [],
                'airlinesName' => isset($itin['fields']['airlinesName']) ? $itin['fields']['airlinesName'] : [],
                'airportDepartureCode' => isset($itin['fields']['airportDepartureCode']) ? $itin['fields']['airportDepartureCode'] : [],
                'airportDepartureCity' => isset($itin['fields']['airportDepartureCity']) ? $itin['fields']['airportDepartureCity'] : [],
                'airportArrivalCode' => isset($itin['fields']['airportArrivalCode']) ? $itin['fields']['airportArrivalCode'] : [],
                'airportArrivalCity' => isset($itin['fields']['airportArrivalCity']) ? $itin['fields']['airportArrivalCity'] : [],
                'flightDuration' => isset($itin['fields']['flightDuration']) ? $itin['fields']['flightDuration'] : [],
            ];

            $flights = [];
            $flightCount = count($flightData['airlinesCode']); // Counting Jumlah Flight by Code
            if ($flightCount !== 0) {
                for ($i = 0; $i < $flightCount; ++$i) {
                    $flight = [
                        'airlinesIcon' => isset($flightData['airlinesIcon'][$i]['url']) ? $flightData['airlinesIcon'][$i]['url'] : '',
                        'airlinesCode' => isset($flightData['airlinesCode'][$i]) ? $flightData['airlinesCode'][$i] : '',
                        'airlinesName' => isset($flightData['airlinesName'][$i]) ? $flightData['airlinesName'][$i] : '',
                        'airportDepartureCode' => isset($flightData['airportDepartureCode'][$i]) ? $flightData['airportDepartureCode'][$i] : '',
                        'airportDepartureCity' => isset($flightData['airportDepartureCity'][$i]) ? $flightData['airportDepartureCity'][$i] : '',
                        'airportArrivalCode' => isset($flightData['airportArrivalCode'][$i]) ? $flightData['airportArrivalCode'][$i] : '',
                        'airportArrivalCity' => isset($flightData['airportArrivalCity'][$i]) ? $flightData['airportArrivalCity'][$i] : '',
                        'flightDuration' => isset($flightData['flightDuration'][$i]) ? $flightData['flightDuration'][$i] : '',
                    ];
                    $flights[] = $flight;
                }
            }
            // Restructure Flight Schedule End

            // Restructure Hotel Start
            $hotels = [
                'hotelName' => array_values($itin['fields']['hotelName']),
                'hotelNearestMasjid' => array_values($itin['fields']['hotelNearestMasjid']),
                'hotelLocation' => array_values($itin['fields']['hotelLocation']),
                'hotelCity' => array_values($itin['fields']['hotelCity']),
                'hotelThumbnail' => array_values($itin['fields']['hotelThumbnail']),
            ];
            // Restructure Hotel End

            // Restructure Attraction Start
            $transformedData = [];

            for ($i = 0; $i < count($itin['fields']['attractionCategory']); ++$i) {
                $transformedData[] = [
                    'attractionCategory' => $itin['fields']['attractionCategory'][$i],
                    'attractionLocation' => $itin['fields']['attractionLocation'][$i],
                    'attractionName' => $itin['fields']['attractionName'][$i],
                ];
            }
            $resultItin = [$transformedData];
            // Restructure Attraction End

            $transitin = [
                'id' => $itin['id'],
                'title' => $itin['fields']['title'],
                'description' => $itin['fields']['description'],
                'flight' => $flights,
                'hotel' => $hotels,
                'attraction' => $resultItin,
                'meal' => isset($itin['fields']['meal']) ? $itin['fields']['meal'] : [],
            ];
            $simpleitins[] = $transitin;
        }
        $itins = $simpleitins;
        // Fetch and Transform Itineraries End

        // Mapping Products and Itin Start
        $products = array_map(function ($products) use ($itins) {
            $itinsMapped = [];
            foreach ($products['itinerary'] as $prdItins) {
                $record = collect($itins)->firstWhere('id', $prdItins);
                if ($record) {
                    $itinsMapped[] = $record;
                }
            }

            return [
                'id' => $products['id'],
                'slug' => $products['slug'],
                'thumbnail' => $products['thumbnail'],
                'gallery' => $products['gallery'],
                'name' => $products['name'],
                'description' => $products['description'],
                'includes' => $products['includes'],
                'excludes' => $products['excludes'],
                'price_normal' => number_format($products['price_normal'], 0, ',', '.'),
                'price_discount' => number_format($products['price_discount'], 0, ',', '.'),
                'seat' => $products['seat'],
                'seat_taken' => $products['seat_taken'],
                'seat_left' => $products['seat_left'],
                'seat_percentage' => $products['seat_percentage'],
                'discount_percent' => $products['discount_percent'],
                'duration' => $products['duration'],
                'duration_night' => $products['duration'] - 1,
                'airlines_icon' => $products['airlines_icon'],
                'airlines_name' => $products['airlines_name'],
                'hotel_name' => $products['hotel_name'],
                'itinerary' => $itinsMapped,
            ];
        }, $products);
        // Mapping Products and Itin End

        // return response($products);

        if ($slug != null) {
            return view('test', compact('products'));
        } else {
            return view('home', compact('products'));
        }
    }
}
