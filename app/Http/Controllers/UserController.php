<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProductLessionPurchase;

class UserController extends Controller
{
    public function dashboard(Request $req)
    {
        $data = (object)[];
        $user = $req->user();
        /***************** Transaction Log ****************/
        $transactionLogData = [];
        $userPurchaseTransaction = UserProductLessionPurchase::where('userId',$user->id)->groupBy(['transactionId'])->latest()->paginate(8);
        foreach ($userPurchaseTransaction as $key => $userTrasaction) {
            $offersTransaction = UserProductLessionPurchase::with('offers_details_all')->where('userId',$user->id)->where('transactionId',$userTrasaction->transactionId)->where('type_of_product','offer')->groupBy('offerId')->get();
            $seriesTransaction = UserProductLessionPurchase::with('product_series_all')->where('userId',$user->id)->where('transactionId',$userTrasaction->transactionId)->where('type_of_product','series')->groupBy('productSeriesId')->get();
            $lessionsTransaction = UserProductLessionPurchase::with('product_series_lession_all')->where('userId',$user->id)->where('transactionId',$userTrasaction->transactionId)->where('type_of_product','lession')->groupBy('productSeriesLessionId')->get();
            $transactionLogData[] = [
                'transaction' => $userTrasaction->transaction,
                'offers' => $offersTransaction,
                'series' => $seriesTransaction,
                'lession' => $lessionsTransaction,
                'date' => date('d M, Y',strtotime($userTrasaction->created_at)),
                'time' => date('h:i:s A',strtotime($userTrasaction->created_at)),
            ];
        }
        $data->transactionLog = $transactionLogData;
        /***************** Transaction Log End****************/
        return view('user.dashboard', compact('data', 'req'));
    }
}
