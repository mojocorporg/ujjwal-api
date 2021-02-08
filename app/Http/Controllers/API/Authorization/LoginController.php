<?php

namespace App\Http\Controllers\API\Authorization;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'username' => 'required',
            'os_type' => 'required',
            'token'=> 'sometimes',
            'notification_token'=>'sometimes',
            'notification_token'=>'sometimes',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            $user = new User();
            $user->name = $request->username;
            $user->phone_number = $request->phone_number;
            $user->notification_token = $request->notification_token;
            $user->os_type = $request->os_type ? $request->os_type : 'android';
            $user->save();

            $token = $user->createToken($request->phone_number)->plainTextToken;

            return response()->json([
                'token' => $token,
                'status' => true,
                'message' => 'Login successfully',
            ]);
        }
        $user->notification_token = $request->notification_token;
        $user->os_type = $request->os_type;
        $user->update();
        $token = $user->createToken($request->phone_number)->plainTextToken;

        return response()->json([
            'token' => $token,
            'status' => true,
            'message' => 'Login successfully',
        ]);
    }
}
