<?php

namespace App\Http\Resources\API\Review;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBusinessReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $user = $request->user();
        return [
            'id' => $this->id,
            'name' => $this->title,
            // 'selected' => $this->reviews->where('user_id', $user->id)->where('business_id', $this->business->id)->count() ? true : false,
        ];
    }
}
