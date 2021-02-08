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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function without_login(Request $request)
    {
        $business = Business::with('phones', 'tags', 'reviews')->where('status', 1)->get();

        return WithoutLoginBusinessListResource::collection($business);
        
    }

    public function with_login(Request $request)
    {
        $business = Business::with('phones', 'tags', 'reviews')->where('status', 1)->get();

        return BusinessListResource::collection($business);
        
    }


    public function accepted(Request $request)
    {
        $user = $request->user();

        $business = Business::with('phones', 'tags', 'reviews')
                    ->whereHas('business_user', function($query) use($user){
                        $query->where('user_id', $user->id)->where('status', 'accepted');
                    })
                    ->where('status', 1)
                    ->get();

        return BusinessListResource::collection($business);
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required',
            'reviews' => 'sometimes'
        ]);

        $user = $request->user();

        $business = Business::find($request->business_id);

        $reviewArray = [];
        if($request->reviews){
            foreach($request->reviews as $key => $review){
                array_push($reviewArray, ['review_id' => $review, 'business_id' => $business->id, 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        $user->reviews()->where('pivot.user_id', $user->id)->sync($reviewArray);

        return response()->json(['status' => true, 'message' => 'Review Added Successfully']);

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

        $user_business = $user->business_user();
        
        if(!$user_business){
            $user_business->create(['business_id' => $business->id, 'call_count' => 1]);
        }else{
            $user_business = $user_business->first();
            $user_business->call_count = $user_business->call_count + 1;
            $user_business->update();
        }
        // $user_business->increment('call_count');

        return response()->json(['status' => true, 'message' => 'Business Call Count Updated']);
    }


    public function share_count(Request $request, Business $business)
    {

        $user = $request->user();

        $user_business = $user->business_user();
        
        if($user_business){
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


    public function mark(Request $request, Business $business)
    {
        $request->validate([
            'status' => ['required', Rule::in(['accepted', 'rejected'])],
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
