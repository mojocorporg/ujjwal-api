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
            'notification_token'=>'sometimes',
            'referral_code' => 'sometimes'
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            $user = new User();
            $user->name = $request->username;
            $user->phone_number = $request->phone_number;
            $user->notification_token = $request->notification_token;
            $user->os_type = $request->os_type ? $request->os_type : 'android';
            $user->referral_code = generateRandomString(6);
            $user->save();

            $referral_user = User::where('referral_code', $request->referral_code)->first();
            if($request->referral_code && $referral_user){
                $user->referral_id = $referral_user->id;
                $user->update();
            }
        }
        else{
            $user->notification_token = $request->notification_token;
            $user->os_type = $request->os_type;
            $user->update();
        }

        $token = $user->createToken($request->phone_number)->plainTextToken;

        return response()->json([
            'token' => $token,
            'status' => true,
            'user_id' => $user->id,
            'message' => 'Login successfully',
        ]);
    }
}
