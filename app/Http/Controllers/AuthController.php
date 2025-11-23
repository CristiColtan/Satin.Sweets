<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //dd($request);
        //Log::debug('log', $request->all());

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);
        if (!Auth::attempt($credentials, $remember)) {
            return response(['message' => 'Invalid credentials'], 422);
        }

        $user = Auth::user();
//        if (!$user->is_admin) {
//            Auth::logout();
//            return response(['message' => 'You don\'t have permission to authenticate as admin'], 403);
//        }

        $user->loadCount('favorites')
            ->load(['favorites:id']);

        $token = $user->createToken('main')->plainTextToken;
        return response(['user' => new UserResource($user), 'token' => $token]);
        //return response(['user' => new UserResource($user), 'token' => $token])->cookie('token', $token, 60 * 24);
    }

    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            $user->currentAccessToken()->delete();
        }
        return response()->noContent();
        //return response('Logged out successfully!', 204)->cookie('token', '', -1);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }
}
