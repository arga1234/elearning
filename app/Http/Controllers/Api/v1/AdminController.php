<?php

namespace App\Http\Controllers\api\v1;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class AdminController extends Controller
{
    //
    public function index()
    {
      $users = User::select('_id', 'name', 'school.sekolah')->get();

      return $users;
    }

    public function userById($id)
    {
      $user = User::find($id);

      return $user;
    }

    public function userByRole($role)
    {
      $request = new Request([
        'role' => $role
      ]);
      $input = $request->all();
      $validator = Validator::make($input, [
        'role' => [
          'required',
          Rule::in(['admin', 'assessor', 'user']),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $users = User::where('role', '=', $request->role)->get();

      return $users;
    }

    public function changeRole(Request $request, $id)
    {
      $input = $request->all();
      $validator = Validator::make($input, [
        'role' => [
          'required',
          Rule::in(['admin', 'assessor', 'user']),
        ]
      ]);

      if ($validator->fails()) {
        return response()->json([
          $validator->errors()
        ], 417);
      }

      $user = User::find($id);
      $user->role = $request->role;
      $user->save();

      return response()->json([
        'message' => 'Role changed.',
        'email' => $user->email,
        'role' => $user->role
      ], 200);
    }
}
