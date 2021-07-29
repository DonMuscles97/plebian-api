<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function Login(Request $request)
    {

        $content = $request->all()['user'];

        $validator = Validator::make($content, [
            // 'username'  => 'required|unique:users|max:255',
            'email'     => 'required|email',
            'password'  =>  'required'
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->first()];

            return response()->json($error);
                        
        }
        
            $user = User::where('email', $content['email'])->first();
        
            if (! $user || $content['password'] != $user->password) {

                
                return response()->json(['error' => 'Login Credentials incorrect']);
            }

            $token = $user->createToken('loggedIn')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];
        
            return response()->json($response);
        
    }
}
