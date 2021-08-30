<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuitarSeries extends Model
{
    use HasFactory,SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\Models\Category','categoryId','id');
    }

    public function lession()
    {
        return $this->hasMany('App\Models\GuitarLession','guitarSeriesId','id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User','createdBy','id');
    }
}
