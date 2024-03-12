<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\ResetPasswordEmail;
use App\Models\PasswordResetToken;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // protected function tokenExpired($createdAt)
    // {
    //     $expireDuration = config('auth.passwords.users.expire');
    //     $expiryTime = Carbon::parse($createdAt)->addMinutes($expireDuration);

    //     return now()->gt($expiryTime);
    // }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            $token = Str::random(60);
            $resetUrl = 'http://localhost:5173/password-reset/' . $token . '?email=' . urlencode($request->email);
            PasswordResetToken::create([
                'email' => $user->email,
                'token' => $token
            ]);
            Mail::to($user->email)->send(new ResetPasswordEmail($user, $token, $resetUrl));
            return response()->json([
                'status' => true,
                'message' => 'Password Reset link sent successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Please enter a valid Email Address',
            ], 404);
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ]);
        $passwordReset = PasswordResetToken::where('email', $request->email)->where('token', $request->token)->first();
        if (!$passwordReset) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Token'
            ], 400);
        }
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->update(['password' => Hash::make($request->password)]);
        $passwordReset->delete();
        return response()->json([
            'status' => true,
            'message' => 'Password has been reset successfully'
        ], 200);
    }
}
