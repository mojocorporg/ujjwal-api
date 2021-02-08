<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessUser extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'business_id', 'call_count', 'share_count', 'feedback', 'status'];

}
