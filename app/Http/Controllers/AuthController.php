<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function signUp(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users|max:50',
            'name' => 'required|max:30',
            'password' => 'required|max:20'
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Validation failed.'
            ], 400);
        }

        $validated = $validator->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $token = $user->createToken('auth_token');
        
        return response([
            'token' => $token->plainTextToken,
            'user' => [
                'email' => $user->email,
                'name' => $user->name
            ]
        ], 201);
    }

    public function signIn(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:30',
            'password' => 'required|max:20'
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Validation Failed.'
            ], 400);
        }

        $validated = $validator->validated();

        $user = User::firstWhere('email', $validated['email']);

        if ($user && Hash::check($validated['password'], $user->password)) {
            $token = $user->createToken('token');

            return response([
                'token' => $token->plainTextToken,
                'user' => [
                    'email' => $user->email,
                    'name' => $user->name
                ]
            ]);
        }
        
        else
            return response([
                'message' => 'Wrong email or password'
            ], 404);
    }
}
