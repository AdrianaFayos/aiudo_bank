<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
        // REGISTER

        public function register(Request $request){

            $this -> validate( $request, [
    
                'name' => 'required|min:4',
                'lastname' => 'required|min:4',
                'email' => 'required|email',
                'password' => 'required|min:8',
                'dni' => 'required',
                'phone' => 'required',
                'adress' => 'required',
                'birthday'=> 'required'
    
            ]);
    
            $user = User::create ([
    
                'name' => $request->name,
                'lastname' => $request->lastname,
                'streamUsername' => $request->streamUsername,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'dni' => $request->dni,
                'phone' => $request->phone,
                'adress' => $request->adress,
                'birthday'=> $request->birthday
            ]);
    
            $token = $user -> createToken('LaravelAuthApp') -> accessToken;
            return response()->json(['token' => $token], 200);
    
        }
    
        // LOGIN
    
        public function login(Request $request){
            $data = [
                'email' => $request->email,
                'password' => $request->password,
            ];
    
            if (auth()->attempt($data)){
                $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        }

}
