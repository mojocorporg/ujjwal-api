<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->belongsToMany(\App\Models\Tag::class, 'business_tag');
    }

    public function reviews()
    {
        return $this->belongsToMany(\App\Models\Review::class, 'review_user')->withPivot('user_id', 'business_id');
    }

    public function businesses()
    {
        return $this->belongsToMany(\App\Models\Business::class, 'business_users');
    }

    public function business_user()
    {
        return $this->hasMany(\App\Models\BusinessUser::class);
    }

    public function referrals()
    {
        return $this->hasMany(\App\Models\User::class, 'referral_id');
    }

}
