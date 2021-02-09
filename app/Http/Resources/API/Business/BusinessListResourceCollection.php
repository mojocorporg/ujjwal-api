<?php

namespace App\Http\Resources\API\Business;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BusinessListResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'premium'=>true,
            'data'=>$this->collection
        ];
    }
}
