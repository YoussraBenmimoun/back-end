<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   
    public function register(Request $request)
    {
        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'type' => "client",
            'status' => '1'
        ]);
    
        $userId = $user->id;
    
        $client= Client::create([
            'user_id' => $userId,
            'first_name' => $request->input('first_name'),
            'birth_date' => $request->input('birth_date'),
            'address' => $request->input('address'),
            'last_name' => $request->input('last_name'),
            'telephone' => $request->input('telephone'),

        ]);
    
        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }
    
    public function login(Request $request){
        if (!Auth::attempt($request->only('email','password'))) {
            return response([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
    
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
    
        $cookie = cookie('jwt', $token, 60 * 24);
    
        // Récupérer l'ID du host associé à l'utilisateur connecté
        $hostId = $user->host->id;
    
        return response([
            'message' => 'success',
            'token' => $token,
            'hostId' => $hostId, // Envoyer l'ID du host dans la réponse
            'userType' => $user->type // Utilisation du champ 'type' pour le type d'utilisateur
        ])->withCookie($cookie);
    }
    
    public function logout(Request $request){
        //auth()->user()->tokens()->delete();
        $cookie=Cookie::forget('jwt');

        return response()->json([
            'message'=>'Success'
        ],200);

    }
    
}
