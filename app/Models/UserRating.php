<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRating extends Model
{
    use HasFactory, SoftDeletes;

    public function rated_user_details()
    {
        return $this->belongsTo('App\Models\User','ratedUserId','id');
    }
}
