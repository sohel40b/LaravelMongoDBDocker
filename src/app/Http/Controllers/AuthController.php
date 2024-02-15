<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        try { 
            if(Auth::attempt($request->only(['email', 'password']))){
                $user = User::where('email', $request->email)->first();

                return response()->json([
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                    'data' => Auth::user(),
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function register(RegisterRequest $request){
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function dashboard(){
        $user = User::where('_id', Auth::id())->first();
        return $user;
    }

}
