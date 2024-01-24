<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        try {

            $user = User::where('email',$request->email)->first();

            if(!$user || !Hash::check($request->password,$user->password)){

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            if (Auth::attempt($request->only('email', 'password'))) {

                $user = User::find(Auth::id());

                $token = $user->createToken("API TOKEN")->plainTextToken;

                return response()->json([
                        'status' => true,
                        'message' => 'Login Successful',
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ], 200);
            }else{

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong '.$th->getMessage()
            ], 400);
        }
    }
    public function signup(Request $request)
    {
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'data' => $user
            ], 201);

        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong '.$th->getMessage()
            ], 400);
        }

    }

}
