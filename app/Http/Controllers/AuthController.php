<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {

        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        $login = Auth::attempt($fields);
        if ($login) {
            $user = Auth::user();
            $token = $request->user()->createToken($request->username)->plainTextToken;
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } else {
            return response(["message" => "Invalid Credentials"], 200);
        }
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|unique:user,email',
            'password' => 'required|string'
        ]);
        if($request->usertype){
            $fields = $fields + ["usertype" => $request->usertype];
        }
        $user = User::create($fields);
        $userdetails = new User_details;
        $userdetails->user_id = $user->id;
        $userdetails->firstname = $request->firstname;
        $userdetails->lastname = $request->lastname;
        $userdetails->email = $request->email;
        $userdetails->save();

        return response(["message" => "success"], 200);
    }
}
