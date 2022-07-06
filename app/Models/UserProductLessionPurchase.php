<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProductLessionPurchase extends Model
{
    use HasFactory, SoftDeletes;

    public function product_series()
    {
        return $this->belongsTo('App\Models\ProductSeries', 'productSeriesId', 'id');
    }

    public function product_series_lession()
    {
        return $this->belongsTo('App\Models\ProductSeriesLession', 'productSeriesLessionId', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction', 'transactionId', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'categoryId', 'id');
    }

    public function users_details()
    {
        return $this->belongsTo('App\Models\User', 'userId', 'id');
    }

    /******************************** Deleted Data ********************************/

    public function product_series_all()
    {
        return $this->belongsTo('App\Models\ProductSeries', 'productSeriesId', 'id')->withTrashed();
    }

    public function product_series_lession_all()
    {
        return $this->belongsTo('App\Models\ProductSeriesLession', 'productSeriesLessionId', 'id')->withTrashed();
    }

    public function users_details_all()
    {
        return $this->belongsTo('App\Models\User', 'userId', 'id')->withTrashed();
    }

    public function offers_details_all()
    {
        return $this->belongsTo('App\Models\Offer', 'offerId', 'id')->withTrashed();
    }

    public function author_details()
    {
        return $this->belongsTo('App\Models\User', 'authorId', 'id')->withTrashed();
    }
}
