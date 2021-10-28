<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Referral;use DB;use App\Models\User;use Hash;
use App\Models\UserPoints;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function setReferrerBy($user,$referalCode='')
    {
        if(!empty($referalCode)){
            $referee = User::where('referral_code',$referalCode)->first();
            if($referee){
                $user->referred_by = $referee->id;
                $user->save();
                $data = ['message' => 'you friend '.$user->name.' joined by your referral code'];
                $notification = addNotification($referee->id,$data);
            }
        }
    }

    // public function addNewPointTotheUser($user,$points,$remark='')
    // {
    //     $newPoint = new UserPoints;
    //         $newPoint->userId = $user->id;
    //         $newPoint->points = $points;
    //         $newPoint->remarks = $remark;
    //     $newPoint->save();
    //     return $newPoint;
    // }
}
