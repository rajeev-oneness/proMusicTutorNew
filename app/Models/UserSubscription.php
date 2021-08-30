<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use HasFactory,SoftDeletes;

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function subscription()
    {
        return $this->belongsTo('App\Models\SubscriptionPlan','subscriptionId','id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction','transactionId','id');
    }
}
