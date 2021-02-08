<?php

namespace App\Http\Resources\API\Business;

use App\Http\Resources\API\Tag\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Review\UserBusinessReviewResource;

class WithoutLoginBusinessListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
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
            'reviews' => [],
        ];
    }
}
