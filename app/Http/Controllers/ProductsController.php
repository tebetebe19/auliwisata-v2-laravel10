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
        $tableIDgalleries = env('AIRTABLE_TABLE_ID_GALLERIES');

        // Fetch Gallery Start
        $responseGalleries = Http::withHeaders(['Authorization' => 'Bearer '.$apiKey])
            ->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableIDgalleries);

        // return response($responseGalleries);
        $galleries = json_decode($responseGalleries, true)['records'];

        // return response($galleries);
        // Fetch Gallery End

        // Restructure gallery start
        foreach ($galleries as $gallery) {
            // Transform images start
            $simpleImages = [];
            foreach ($gallery['fields']['images'] as $img) {
                $simpleImages[] = $img['url'];
            }
            // Transform images end
            $transGallery = [
                'id' => $gallery['id'],
                'name' => $gallery['fields']['name'],
                'thumbnail' => $gallery['fields']['thumbnail'][0]['url'],
                'images' => $simpleImages,
            ];
            $simpleGallery[] = $transGallery;
        }
        $galleries = $simpleGallery;

        // return response($galleries);
        // Restructure gallery end

        // Fetch Product Start
        $filterFormula = 'AND(SEARCH("'.$slug.'", {slug}), {hide} = FALSE())';
        $responseProducts = Http::withHeaders(['Authorization' => 'Bearer '.$apiKey])
            ->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableIDproducts, [
                'filterByFormula' => $filterFormula,
            ]);
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
                'is_full' => isset($pd['fields']['is_full']) ? true : false,
                'type' => $pd['fields']['type'],
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
                'is_full' => $products['is_full'],
                'type' => $products['type'],
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
        // Mapping produts with hotels end

        // Sort data by is_full = false start
        $productsData = collect($products);
        $sortedProducts = $productsData->sortBy(function ($item) {
            return $item['is_full'] ? 1 : 0;
        });
        $products = $sortedProducts->values()->all();
        // Sort data by is_full = false end

        // return response($products);
        // return view('home', compact('products'));

        $umroh = collect($products)->where('type', 'umroh');
        $international = collect($products)->where('type', 'international');
        $keywords = implode(',', array_column($products, 'slug'));

        // return response($galleries);

        if ($slug != null) {
            return view('detail-product', compact('products'));
        } else {
            return view('home', compact('galleries', 'products', 'umroh', 'international', 'keywords'));
        }
    }
}
