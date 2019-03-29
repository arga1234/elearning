<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use Illuminate\Http\Request;
use Validator;

class PassportController extends Controller
{
    //
    public function register(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:3',
        'c_password' => 'required|same:password',
        'attendedWorkshop' => 'required',
        'school' => 'required'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'attendedWorkshop' => $request->attendedWorkshop,
        'school' => $request->school,
        'role' => 'user'
      ]);

      return response()->json([
        'name' => $user->name,
        'message' => 'Register success!'
      ], 200);
    }

    public function login(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $credentials = $request->only(['email', 'password']);

      if (auth()->attempt($credentials)) {
        $user = auth()->user();
        /*
        ** FIX LATER FOR THE ROLES
        ** FIX LATER FOR THE ROLES
        ** FIX LATER FOR THE ROLES
        */
        if ($user->role == 'user') {
          $token = $user->createToken('GSM', [$user->role])->accessToken;
        } else if ($user->role == 'admin') {
          $token = $user->createToken('GSM', ['*'])->accessToken;
        }

        return response()->json([
          'token_type' => 'Bearer',
          'token' => $token,
          'role' => $user->role
        ], 200);
      } else {
        return response()->json([
          'error' => 'Unauthorized'
        ], 401);
      }
    }

    public function adminLogin(Request $request)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $credentials = $request->only(['email', 'password']);

      if (auth()->attempt($credentials)) {
        $user = auth()->user();
        if ($user->role == 'admin') {
          $token = $user->createToken('GSM', ['*'])->accessToken;
        } else {
          return response()->json([
            'error' => 'You are not allowed, please login through e-learning page.'
          ], 401);
        }

        return response()->json([
          'token_type' => 'Bearer',
          'token' => $token,
          'role' => $user->role
        ], 200);
      } else {
        return response()->json([
          'error' => 'Unauthorized'
        ], 401);
      }
    }

    public function logout(Request $request)
    {
      $request->user()->token()->revoke();

      return response()->json([
        'message' => 'Logout success!'
      ]);
    }

    public function details()
    {
      return response()->json([
        'user' => auth()->user()
      ], 200);
    }
}
