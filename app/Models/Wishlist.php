<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use HasFactory, SoftDeletes;

    public function wishlist_users()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function wishlist_series()
    {
        return $this->belongsTo('App\Models\ProductSeries', 'product_id', 'id');
    }
}
