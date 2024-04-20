<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Offer;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return response()->json(['data' => $hotels]);
    }

    public function hotel_offers()
    {
        $offers = Offer::whereNotNull('hotel_id')->with('images')->get();
        $hotelsWithOffers = [];
        foreach ($offers as $offer) {
            $hotel = Hotel::find($offer->hotel_id);
            if ($hotel) {
                $hotelsWithOffers[] = ['hotel' => $hotel, 'offer' => $offer];
            }
        }
        return response()->json(['data' =>  $hotelsWithOffers])->header('Content-Type', 'application/json');
    }
    

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        $offers = Offer::where('hotel_id', $id)->with('images')->get();
        return response()->json(['hotel' => $hotel, 'offers' => $offers]);
    }

    public function getHotelsByStars(Request $request)
    {
        $nbr_stars = $request->query('nbr_stars');

        $hotels = Hotel::where('nbr_stars', $nbr_stars)->get();

        return response()->json($hotels);
    }

    public function getHotels(Request $request)
{
    $selectedCity = $request->input('city');
    $selectedStars = $request->input('stars');

    $hotels = Hotel::query();

    if ($selectedCity) {
        $hotels->where('city', $selectedCity);
    }

    if ($selectedStars) {
        $hotels->where('stars', $selectedStars);
    }

    $filteredHotels = $hotels->get();

    return response()->json($filteredHotels);
}
}
