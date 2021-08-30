<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGuitarLessionPurchase extends Model
{
    use HasFactory,SoftDeletes;

    public function guitar_series()
    {
        return $this->belongsTo('App\Models\GuitarSeries','guitarSeriesId','id');
    }

    public function guitar_lession()
    {
        return $this->belongsTo('App\Models\GuitarLession','guitarSeriesLessionId','id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction','transactionId','id');
    }
}
