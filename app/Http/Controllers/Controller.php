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

    public function generateUniqueReferral()
    {
        $random = generateUniqueAlphaNumeric(7);
        $referral = Referral::where('code',$random)->first();
        if(!$referral){
            $referral = new Referral();
            $referral->code = strtoupper($random);
            $referral->save();
            return $referral;
        }
        return $this->generateUniqueReferral();
    }

    public function createNewUser($userData)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = emptyCheck($userData->name);
            $user->email = $userData->email;
            $user->password = Hash::make($userData->password);
            $user->user_type = $userData->user_type;
            if(!empty($userData->image)){
                $user->image = $userData->image;
            }
            $user->save();
            $referral = '';
            if(!empty($userData->referral))
                $referral = $userData->referral;
            $this->setReferralCode($user,$referral);
            // sendMail();
            DB::commit();
            return $user;
        }catch (Exception $e) {
            DB::rollback();
            return (object)[];
        }
    }

    public function setReferralCode($user,$referalCode='')
    {
        $referral = $this->generateUniqueReferral();
        $user->referral_code = $referral->code;
        if($referalCode != ''){
            $referralFind = Referral::where('code',$referalCode)->first();
            if($referralFind){
                $referredBy = User::find($referralFind->userId);
                $this->addNewPointTotheUser($referredBy,10,'Referral Bonus for UserId:'.$user->id);
                $user->referred_by = $referredBy->id;
            }
        }
        $user->save();
        $referral->userId = $user->id;
        $referral->save();
        $this->addNewPointTotheUser($user,10,'Joining Bonus');
    }

    public function addNewPointTotheUser($user,$points,$remark='')
    {
        $newPoint = new UserPoints;
            $newPoint->userId = $user->id;
            $newPoint->points = $points;
            $newPoint->remarks = $remark;
        $newPoint->save();
        return $newPoint;
    }
}
