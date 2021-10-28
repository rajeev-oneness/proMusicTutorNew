<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    public function user_details()
    {
        return $this->belongsTo('App\Models\User','userId','id')->withTrashed();
    }


    public function notificationMarkAsReadOrUnRead($userId,$status = true,$notificationId = 0)
    {
        $notification = Notification::where('userId',$userId);
        if($notificationId > 0){
            $notification = $notification->where('id',$notificationId);
        }
        $updateStatusTo = 1;
        if(!$status){
            $updateStatusTo = 0;
        }
        $notification = $notification->update(['read' => $updateStatusTo]);
    }
}
