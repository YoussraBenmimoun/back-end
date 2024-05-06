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
public function register(Request $request) {
    $validatedData = $request->validate([
        "first_name"=>"required|string",
        "last_name"=>"required|string",
        "address"=>"required|string",
        "telephone"=>"required|string",
        "birth_date"=>"required|date",
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',

    ]);

    // Create a new user record
    $user = User::create([
        'first_name'=>$validatedData['first_name'],
        'last_name'=>$validatedData['last_name'],
        'address'=>$validatedData['address'],
        'telephone'=>$validatedData['telephone'],
        'birth_date'=>$validatedData['birth_date'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']), 

    ]);

    // Attempt to log in the newly registered user
    if (!Auth::login($user)) {
        return response([
            'message' => 'Failed to log in after registration'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    // Generate a token for the authenticated user
    $token = $user->createToken('token')->plainTextToken;

    // Create an HTTP cookie containing the token
    $cookie = cookie('jwt', $token, 30 * 24 * 60); // 30 days expiration

    // Construct the response with user data and token
    return response([
        'message' => 'success',
        'token' => $token,
        'user' => $user, // You can customize the user data you want to send
    ])->withCookie($cookie);
}

public function login(Request $request)
{
    if (!Auth::attempt($request->only('email', 'password'))) {
        return response([
            'message' => 'Invalid credentials'
        ], Response::HTTP_UNAUTHORIZED);
    }

    $user = Auth::user();
    \Log::info('Authenticated user:', $user->toArray());
    $token = $user->createToken('token')->plainTextToken;

    // Set the token in a cookie
    $cookie = cookie('jwt', $token, 60 * 24); // Set the cookie to expire in 24 hours

    // Check if the user has a host relationship
    $hostId = optional($user->host)->id;

    return response([
        'message' => 'success',
        'token' => $token,
        'hostId' => $hostId,
        'userType' => $user->type
    ])->withCookie($cookie); // Attach the cookie to the response
}

    
    
    public function logout(Request $request){
        //auth()->user()->tokens()->delete();
        $cookie=Cookie::forget('jwt');

        return response()->json([
            'message'=>'Success'
        ],200);

    }
    
}
