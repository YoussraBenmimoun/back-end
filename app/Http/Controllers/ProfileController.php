<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($userId)
    {
        $user = User::findOrFail($userId);

        return response()->json(['user' => $user], Response::HTTP_OK);
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);

        return response()->json(['user' => $user], Response::HTTP_OK);
    }

    public function update(UpdateUserProfileRequest $request, $userId)
    {
        $user = User::findOrFail($userId);
        $profile = $user->profile ?? new Profile();

        $profile->fill($request->validated());
        $user->profile()->save($profile);

        return response()->json(['message' => 'Profile updated successfully'], Response::HTTP_OK);
    }

    public function updateUserAccount(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $currentUser = Auth::user();

        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ]);

        $user->update($request->only('name', 'email', 'first_name', 'last_name'));

        return response()->json(['message' => 'User account updated successfully'], Response::HTTP_OK);
    }

    public function updateUserPassword(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['password' => Hash::make($request->password)]);

        return response()->json(['message' => 'Password updated successfully'], Response::HTTP_OK);
    }
}
