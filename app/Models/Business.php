<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    public $fillable = [
        'company_name',
        'owner_name',
        'description',
        'address',
        'pincode',
        'city',
        'state',
        'lat',
        'long',
        'status'
    ];

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
        return $this->belongsToMany(\App\Models\Review::class, 'review_user')->withPivot('user_id', 'business_id');
    }

    public function business_user()
    {
        return $this->hasMany(\App\Models\BusinessUser::class);
    }
}
