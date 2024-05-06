<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Host;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthHostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
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
     
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    $host = Host::find($id);
    if (!$host) {
        return response()->json(['error' => 'Host not found'], 404);
    }
    return response()->json(['data' => $host]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $host = Host::findOrFail($id);
        return response()->json(['data'=>$host]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $host = Host::findOrFail($id);
        
        $rules = [
            'CIN' => 'sometimes|required|string',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'address' => 'nullable|string|max:255',
            'telephone' => 'sometimes|required|string|max:255',
            'birth_date' => 'sometimes|required|date',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $host->update($request->only(['CIN', 'first_name', 'last_name', 'address', 'telephone', 'birth_date']));
    
        return response()->json(['message' => 'Host information updated successfully', 'host' => $host]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $host = Host::find($id);

    if (!$host) {
        return response()->json(['error' => 'Host not found'], 404);
    }
    // if ($host->id !== auth()->user()->id) {
    //     return response()->json(['error' => 'Unauthorized'], 403);
    // }

    $host->delete();

    return response()->json(['message' => 'Host account deleted successfully']);
}

// public function logout(Request $request)
// {
//     Auth::guard('host')->logout();

//     $request->session()->invalidate();

//     return redirect('/');
// }

}
