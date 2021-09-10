<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProductLessionPurchase extends Model
{
    use HasFactory,SoftDeletes;

    public function product_series()
    {
        return $this->belongsTo('App\Models\ProductSeries','productSeriesId','id');
    }

    public function product_series_lession()
    {
        return $this->belongsTo('App\Models\ProductSeriesLession','productSeriesLessionId','id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction','transactionId','id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','categoryId','id');
    }
}
