<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; 
use App\Models\Reservation;
use App\Models\Client;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $reservations = Reservation::get();
        return response()->json($reservations);
    }

    public function getOfferId()
    {
        $host = auth()->user();
    
        if (!$host) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $hostId = $host->id;
        $host = Host::where('user_id', $hostId)->first();

        if (!$host) {
            return response()->json(['error' => 'Host not found'], 404);
        }
    
        $offerId = $host->offer_id;
    
        return response()->json(['offer_id' => $offerId]);
    }
    

    public function store(Request $request)
    {
        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'type' => "host",
            'status' => '1'
        ]);
    
        $userId = $user->id;
    
        $host = Host::create([
            'user_id' => $userId,
            'first_name' => $request->input('first_name'),
            'company_name' => $request->input('company_name'),
            'birth_date' => $request->input('birth_date'),
            'address' => $request->input('address'),
            'last_name' => $request->input('last_name'),
            'CIN' => $request->input('CIN'), 
        ]);
    
        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'host' => $host]);
    }

    public function update(Request $request, $id)
{
    \Log::info('Received update request data:', $request->all()); 

    $client = Client::findOrFail($id);

    $rules = [
        'first_name' => 'sometimes|required|string|max:255',
        'last_name' => 'sometimes|required|string|max:255',
        'address' => 'nullable|string|max:255',
        'telephone' => 'sometimes|required|string|max:255',
        'birth_date' => 'sometimes|required|date',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        \Log::error('Validation failed for client update.', [
            'client_id' => $id,
            'errors' => $validator->errors()->toArray(),
        ]);
        return response()->json(['errors' => $validator->errors()], 422);
    }
    
    $client->fill($request->only(['first_name', 'last_name', 'address', 'telephone', 'birth_date']));
    $client->save();

    \Log::info('Client information updated successfully');

    return response()->json(['message' => 'Client information updated successfully', 'client' => $client]);
}

public function destroy($id)
{
    $client = Client::find($id);

    if (!$client) {
        return response()->json(['error' => 'Client not found'], 404);
    }
    // if ($client->id !== auth()->user()->id) {
    //     return response()->json(['error' => 'Unauthorized'], 403);
    // }

    $client->delete();

    return response()->json(['message' => 'Client account deleted successfully']);
}


}
