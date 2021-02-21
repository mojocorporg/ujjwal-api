<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Business;
use App\Models\BusinessUser;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_users=User::count();
        $total_businesses=Business::count();
        $total_calls=BusinessUser::sum('call_count');
        $total_referrals=User::where('referral_id','!=',null)->count();
        
        return view('home',compact('total_users','total_businesses','total_calls','total_referrals'));
    }
}
