<?php

namespace App\Http\Controllers\API\Review;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Review\UserBusinessReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('status', 1)->get();

        return UserBusinessReviewResource::collection($reviews);
    }
}
