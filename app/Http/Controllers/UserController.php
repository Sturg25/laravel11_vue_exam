<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function getList(Request $request)
    {
        
        $list = User::with('user_details')->get();
        return response()->json($list);
    }

    public function updateUser(Request $request)
    {
        $user = User::find($request->id);

        $user->usertype = $request->role;

        $user->save();
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);

        $user->delete();
    }
}
