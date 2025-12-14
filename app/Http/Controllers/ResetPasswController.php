<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => ['required', 'email'],]);

        $status = Password::sendResetLink($request->only('email'));
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent successfully']);
        }

        return response()->json([
            'message' => __($status),
        ], 422);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        if ($request['old_password'] === $request['new_password']) {
            throw ValidationException::withMessages([
                'new_password' => ['Parola nouă trebuie să fie diferită de cea veche.'],
            ]);
        }

        $user = $request->user();

        $user->forceFill([
            'password' => Hash::make($request->new_password),
        ])->save();

        return response()->json(['message' => 'Parola a fost resetata cu succes.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Parola a fost resetată cu succes.',
            ]);
        }

        return response()->json([
            'message' => __($status),
        ], 422);
    }
}
