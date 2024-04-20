<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $id = $request->id;
        $location = $request->location;
        $pickuptime = Carbon::parse($request->pickuptime);
        $dropofftime = Carbon::parse($request->dropofftime);

        $car_exists = Reservation::where('car_id', $id)
            ->where(function ($query) use ($pickuptime, $dropofftime) {
                $query->where(function ($q) use ($pickuptime) {
                    $q->where('start_date', '<=', $pickuptime)
                        ->where('end_date', '>=', $pickuptime);
                })->orWhere(function ($q) use ($dropofftime) {
                    $q->where('start_date', '<=', $dropofftime)
                        ->where('end_date', '>=', $dropofftime);
                });
            })
            ->exists();
        if($car_exists){
            return response()->json(['message' => 'La voiture est déjà réservée'], Response::HTTP_CONFLICT);
        }

        $reservationId = Reservation::insertGetId([
            'start_date' => $pickuptime,
            'end_date' => $dropofftime,
            'car_pick_up_location' => $location,
            'car_drop_off_location' => $location,
            'car_id' => $id,
            'client_id' => 1, //auth()->id()
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);

        $reservation = Reservation::find($reservationId);

        return response()->json(['message'=>'Réservation ajoutée','reservation'=>$reservation]);
    }

    public function storeTableReservation(Request $request){
        $tables = Table::where('restaurant_id',$request->id)->where('type',$request->type)->get();
        foreach($tables as $table){
            $reservation = Reservation::where('table_id',$table->id)->where('reservation_date_restaurant',$request->date)->exists();
            if(!$reservation){
                Reservation::insert([
                    'table_id' => $table->id,
                    'reservation_date_restaurant' => $request->date,
                    'client_id' => 1, //auth()->id()
                    'created_at' => now(), 
                    'updated_at' => now(), 
                ]);
                return response()->json(['message'=>'Réservation ajoutée']);
            }
        }
        return response()->json(['message'=>'Pas de table disponible']);
    }

    public function storeTableHotel(Request $request)
{
    $rooms = Room::where('room_type_id', $request->room_type_id)
                ->where('nbr_beds', '>=', $request->nbr_beds)
                ->get();

    foreach ($rooms as $room) {
        $reservationExists = Reservation::where('room_id', $room->id)
                                        ->where('start_date', '<=', $request->end_date)
                                        ->where('end_date', '>=', $request->start_date)
                                        ->exists();

        if (!$reservationExists) {
            Reservation::create([
                'room_id' => $room->id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'client_id' => auth()->id(),
            ]);

            return response()->json(['message' => 'Réservation ajoutée']);
        }
    }

    return response()->json(['message' => 'Pas de room disponible']);
}

}
