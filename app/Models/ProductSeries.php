<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSeries extends Model
{
    use HasFactory, SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'categoryId', 'id');
    }

    public function lession()
    {
        return $this->hasMany('App\Models\ProductSeriesLession', 'productSeriesId', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'createdBy', 'id');
    }

    public function genre_data()
    {
        return $this->belongsTo('App\Models\Genre', 'genre', 'id');
    }

    public function instrument_all()
    {
        return $this->belongsTo('App\Models\Instrument','instrumentId','id');
    }
}
