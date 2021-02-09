<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $user= $request->user();

        $user->name=$request->name;
        $user->update();

        return response()->json([
            'status' => true,
            'message' => 'User Name Updated successfully',
        ]);
    }
}
