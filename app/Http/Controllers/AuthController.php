<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //debugging
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
        /*if (!$user->is_admin) {
            Auth::logout();
            return response(['message' => 'You don\'t have permission to authenticate as admin'], 403);
        }*/

        $user->loadCount('favorites')
            ->load(['favorites:id', 'customer:user_id,phone_number,status']);

        $token = $user->createToken('main')->plainTextToken;
        return response(['user' => new UserResource($user), 'token' => $token]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:10', 'unique:customers,phone_number'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
            'terms_cond' => ['accepted'],
            'pol_conf' => ['accepted'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'is_admin' => false,
            ]);

            Customer::create([
                'user_id' => $user->id,
                'phone_number' => $validated['phone_number'],
                'status' => 'active'
            ]);

            return $user;
        });

        return response()->json([
            'message' => 'Cont creat cu succes.',
        ], 201);
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
