<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProductLessionPurchase extends Model
{
    use HasFactory,SoftDeletes;

    public function guitar_series()
    {
        return $this->belongsTo('App\Models\ProductSeries','productSeriesId','id');
    }

    public function guitar_lession()
    {
        return $this->belongsTo('App\Models\ProductSeriesLession','productSeriesLessionId','id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction','transactionId','id');
    }
}
