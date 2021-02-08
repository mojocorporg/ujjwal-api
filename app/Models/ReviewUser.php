<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewUser extends Model
{
    use HasFactory;

    public $table = 'review_user';

    public $fillable = ['business_id', 'user_id', 'review_id'];
    
}
