<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

use App\Models\User;
use Hash;
use Auth;

class UserController extends Controller
{
    public function register(RegistrationRequest $request){

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;


        return(response()->json([
            "success" => true,
            "message" => "User successfully registered",
            "data" => $user,
            "token" => $token
        ]));
    }


    public function login (LoginRequest $request){

        $isAuth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if (!$isAuth){
            return(
                response()->json([
                    "success" => $isAuth,
                    "message" => "Your credentials does not exist",
                    "data" => null
                    ], 400
                )
            );
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return(
            response()->json([
                "success" => $isAuth,
                "message" => "Succesfully Login",
                "token" => $token,
                "user" => $user,
            ]
            )
        );

        
    }

    public function logout (){
        $isAuth = Auth::check();

        // if (!$isAuth){
        //     return([
        //         "success" => false,
        //         "message" => "You are not even login, how can you logout",
        //         "data" => null
        //     ]);
        // }

        Auth::logout();

        return([
            "success" => true,
            "message" => "Successfully logout",
            "data" => null

        ]);
    }
}




