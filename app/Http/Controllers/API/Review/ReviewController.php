<?php

namespace App\Http\Controllers\API\Review;

use App\Models\Review;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Review\UserBusinessReviewResource;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('status', 1)->get();

        return UserBusinessReviewResource::collection($reviews);
    }

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
            foreach($request->reviews as $review){
                array_push($reviewArray, ['review_id' => $review, 'user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()]);
            }
        }

        $business->reviews()->where('pivot.user_id', $user->id)->sync($reviewArray);

        return response()->json(['status' => true, 'message' => 'Review Added Successfully']);

    }
}
