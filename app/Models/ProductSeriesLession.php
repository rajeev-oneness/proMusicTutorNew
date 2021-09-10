<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductLession extends Model
{
    use HasFactory, SoftDeletes;

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currencyId', 'id');
    }

    public function guitar_series()
    {
        return $this->belongsTo('App\Models\ProductSeries', 'productSeriesId', 'id');
    }

    public function genre_data()
    {
        return $this->belongsTo('App\Models\Genre', 'genre', 'id');
    }
}
