<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    public function instrument()
    {
        return $this->belongsTo('App\Models\Instrument','instrumentId','id')->withTrashed();
    }

    public function product_series()
    {
        return $this->hasMany('App\Models\ProductSeries','categoryId','id');
    }
}
