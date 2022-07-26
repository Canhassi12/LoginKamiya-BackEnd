<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    
    public function login(Request $request): Response
    {
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials, true)) {
            return response()->json('email or password invalid', Response::HTTP_UNAUTHORIZED);
        }
        
        $response = [
            "message" => "login successful",
            "token" => auth()->user()->createToken('AuthToken')->plainTextToken,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function register(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:55|',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag()->first();

            return response()->json($messages, Response::HTTP_BAD_REQUEST);
        }

        try {
            $inputs = $request->all();

            $user = [
                'name' => $inputs['name'],
                'email' => $inputs['email'],
                'password' => Hash::make($inputs['password']), 
            ];

            $user = User::create($user); 

            $token = $user->createToken('AuthToken')->plainTextToken;

            $response = [
                'message' => 'User has been added in database with sucessful',
                'user' => $user,
                'token' => $token
            ];

        } catch (Exception $e) {
            return response()->json($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

