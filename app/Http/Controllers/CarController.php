<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\CarResource;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    
    public function index()
    {
        $cars = Car::all();
        return CarResource::collection($cars);
    }

    public function car_offers()
    {
        $offers = Offer::whereNotNull('car_id')->get();
        $cars = [];
        foreach ($offers as $offer) {
            $offerWithImages = Offer::with('images')->find($offer->id)->images();
            $car = Car::find($offer->car_id);
            $cars[] = ['car' => $car, 'offer' => $offerWithImages];
        }
        return response()->json(['offers' => $offers,'cars' => $cars]);
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
