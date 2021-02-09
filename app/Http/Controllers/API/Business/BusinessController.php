<?php

namespace App\Http\Controllers\API\Business;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Business\BusinessListResource;
use App\Http\Resources\API\Business\BusinessDetailsResource;
use App\Http\Resources\API\Business\WithoutLoginBusinessListResource;

class BusinessController extends Controller
{

    public function index(Request $request)
    {

        $request->validate([
            'user_id' => 'sometimes',
            'tags' => 'sometimes',
            'city' => 'sometimes',
        ]);
        
        if($request->tags){
            $tags = explode(',', $request->tags);
            
            $business = Business::with('phones', 'tags', 'reviews')
            ->whereHas('tags', function($query) use($tags){
                $query->whereIn('tags.id', $tags);
            })
            ->where('status', 1)
            ->get();
        }elseif($request->city){
            $business = Business::with('phones', 'tags', 'reviews')
            ->where('city', 'LIKE', '%'.$request->city.'%')
            ->where('status', 1)
            ->get();
        }else{
            $business = Business::with('phones', 'tags', 'reviews')->where('status', 1)->get();
        }

        return BusinessListResource::collection($business);
        
    }


    public function my_list(Request $request)
    {
        $user = $request->user();

        $business = Business::with('phones', 'tags', 'reviews')
                    ->whereHas('business_user', function($query) use($user){
                        $query->where('user_id', $user->id)->where('status', 1);
                    })
                    ->where('status', 1)
                    ->get();

        return BusinessListResource::collection($business);
        
    }


   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        return new BusinessDetailsResource($business);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function call_count(Request $request, Business $business)
    {
        $user = $request->user();

        $user_business = $user->business_user()->where('business_id', $business->id);
        
        if($user_business->count()){
            $user_business = $user_business->first();
            $user_business->call_count = $user_business->call_count + 1;
            $user_business->update();
        }else{
            $user_business->create(['business_id' => $business->id, 'call_count' => 1]);
        }

        return response()->json(['status' => true, 'message' => 'Business Call Count Updated']);
    }


    public function share_count(Request $request, Business $business)
    {

        $user = $request->user();

        $user_business = $user->business_user()->where('business_id', $business->id);
        
        if($user_business->count()){
            $user_business = $user_business->first();
            $user_business->share_count = $user_business->share_count + 1;
            $user_business->update();
        }else{
            $user_business->create(['business_id' => $business->id, 'share_count' => 1]);
        }

        return response()->json(['status' => true, 'message' => 'Business Share Count Updated']);
    }


    public function feedback(Request $request, Business $business)
    {
        $request->validate([
            'feedback' => 'required',
        ]);

        $user = $request->user();

        $user_business = $user->business_user();
        
        if($user_business){
            $user_business = $user_business->first();
            $user_business->feedback = $request->feedback;
            $user_business->update();
        }else{
            $user_business->create(['business_id' => $business->id, 'feedback' => $request->feedback]);
        }

        return response()->json(['status' => true, 'message' => 'Business Share Count Updated']);
    }


    public function add_to_my_list(Request $request, Business $business)
    {
        $request->validate([
            'status' => ['required', Rule::in(['1', '0'])],
        ]);

        $user = $request->user();

        $user_business = $user->business_user();
        
        if($user_business){
            $user_business = $user_business->first();
            $user_business->status = $request->status;
            $user_business->update();
        }else{
            $user_business->create(['business_id' => $business->id, 'status' => $request->status]);
        }

        return response()->json(['status' => true, 'message' => 'Business Review Updated']);
    }


}
