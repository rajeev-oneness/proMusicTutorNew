<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProductLessionPurchase;

class ReportController extends Controller
{
    public function transactionLog(Request $req)
    {
        $transaction = UserProductLessionPurchase::select('*');
        if(!empty($req->seriesId)){
            $transaction = $transaction->where('productSeriesId',$req->seriesId);
        }
        if(!empty($req->lessionId)){
            $transaction = $transaction->where('productSeriesLessionId',$req->lessionId);
        }
        if($req->teacherId){
            $transaction = $transaction->leftjoin('product_series_lessions','user_product_lession_purchases.productSeriesLessionId','=','product_series_lessions.id')->where('product_series_lessions.createdBy',$req->teacherId);
        }
        $transaction = $transaction->latest('user_product_lession_purchases.created_at')->get();
        return view('reports.transactionLog',compact('transaction','req'));
    }
}
