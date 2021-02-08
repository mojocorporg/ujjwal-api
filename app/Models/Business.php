<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    public function phones()
    {
        return $this->hasMany(\App\Models\BusinessPhone::class, 'business_id');
    }

    public function tags()
    {
        return $this->belongsToMany(\App\Models\Tag::class);
    }

    public function reviews()
    {
        return $this->belongsToMany(\App\Models\Review::class, 'review_user')->withPivot('user_id');
    }

    public function business_user()
    {
        return $this->hasMany(\App\Models\BusinessUser::class);
    }
}
