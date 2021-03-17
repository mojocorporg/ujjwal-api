<?php

namespace App\Http\Resources\API\Business;

use App\Models\User;
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
        // $user=$request->user();
        $user=User::find($request->user_id);
        $premium=false;
        if($user)
        $premium=$user->transactions->where('status','paid')->count()?true:false;
        return [
            'premium'=>$premium,
            'data'=>$this->collection
        ];
    }
}
