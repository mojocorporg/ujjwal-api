<?php

namespace App\Http\Resources\API\Business;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDetailsResource extends JsonResource
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
            'lat' => $this->lat,
            'long' => $this->long,
            'description' => $this->description,
            'phones' => $this->phones()->pluck('phone_number')->toArray(),
            'created_at' => Carbon::parse($this->created_at)
        ];
    }
}
