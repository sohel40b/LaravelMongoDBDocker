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
                    'status' => 401,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            if (Auth::attempt($request->only('email', 'password'))) {

                $user = User::find(Auth::id());

                $tokenName = 'fundaToken'.rand(111,999);
                $token = $user->createToken($tokenName)->plainTextToken;

                return response()->json([
                        'status' => 200,
                        'message' => 'Login Successful',
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ], 200);
            }else{

                return response()->json([
                    'status' => 401,
                    'message' => 'Invalid credentials'
                ], 401);
            }

        } catch (Exception $e) {

            return response()->json([
                'message' => 'Something went wrong '.$e->getMessage(),
                'status' => 500
            ], 500);
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
            // dd($user);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'data' => [
                    'user' => $user,
                    'token_type' => 'Bearer',
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ]
            ], 201);

        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong '.$e->getMessage()
            ], 500);
        }

    }

}
