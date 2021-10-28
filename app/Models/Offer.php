<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    public function offer_series()
    {
        return $this->hasMany('App\Models\OfferSeries', 'offer_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User','createdBy','id')->withTrashed();
    }
}
