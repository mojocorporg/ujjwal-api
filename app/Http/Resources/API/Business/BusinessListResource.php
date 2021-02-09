<?php

namespace App\Http\Resources\API\Business;

use App\Http\Resources\API\Review\UserBusinessReviewResource;
use App\Http\Resources\API\Tag\TagResource;
use App\Models\Review;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $request->user();
        return [
            'id' => $this->id,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'owner_name' => $this->owner_name,
            'description' => $this->description,
            'pincode' => $this->pincode,
            'city' => $this->city,
            'state' => $this->state,
            'phones' => $this->phones()->pluck('phone_number')->toArray(),
            'tags' => TagResource::collection($this->tags),
            'reviews' => $user?UserBusinessReviewResource::collection($this->reviews->where('pivot.user_id', $user->id)):[]
        ];
    }
}
