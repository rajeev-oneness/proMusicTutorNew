<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\ProductSeries;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserProductLessionPurchase;

class ReportController extends Controller
{
    public function transactionLog(Request $req)
    {
        $transaction = UserProductLessionPurchase::select('*');
        if (!empty($req->seriesId)) {
            $transaction = $transaction->where('user_product_lession_purchases.productSeriesId', $req->seriesId);
        }
        if (!empty($req->lessionId)) {
            $transaction = $transaction->where('user_product_lession_purchases.productSeriesLessionId', $req->lessionId);
        }
        if ($req->teacherId) {
            $transaction = $transaction->leftjoin('product_series_lessions', 'user_product_lession_purchases.productSeriesLessionId', '=', 'product_series_lessions.id')->where('product_series_lessions.createdBy', $req->teacherId);
        }
        $transaction = $transaction->latest('user_product_lession_purchases.created_at')->paginate(20);

        $teachers = User::select('id', 'name')->where('user_type', 2)->get();

        $available_series = UserProductLessionPurchase::select('product_series.id', 'product_series.title', 'product_series.createdBy')->join('product_series', 'product_series.id', '=', 'user_product_lession_purchases.productSeriesId')->groupBy('product_series.title')->get();

        $available_lessons = UserProductLessionPurchase::select('product_series_lessions.id', 'product_series_lessions.title', 'product_series_lessions.createdBy', 'product_series_lessions.productSeriesId')->join('product_series_lessions', 'product_series_lessions.id', '=', 'user_product_lession_purchases.productSeriesLessionId')->groupBy('product_series_lessions.title')->get();

        return view('reports.transactionLog', compact('transaction', 'req', 'teachers', 'available_series', 'available_lessons'));
    }

    public function bestSeller(Request $req)
    {
        $purchase_list = UserProductLessionPurchase::select('productSeriesId');
        $series = $purchase_list->groupBy('productSeriesId')->get();
        if (!empty($req->seriesId)) {
            $purchase_list = $purchase_list->where('productSeriesId', $req->seriesId);
        }
        if (!empty($req->dateFrom)) {
            $purchase_list = $purchase_list->where('created_at', '>=', $req->dateFrom);
        }
        if (!empty($req->dateTo)) {
            $purchase_list = $purchase_list->where('created_at', '<=', date('Y-m-d', strtotime($req->dateTo . '+ 1 day')));
        }
        $purchase_list = $purchase_list->groupBy('productSeriesId')->pluck('productSeriesId')->toArray();
        $data = [];
        foreach ($purchase_list as $key => $value) {
            $list = UserProductLessionPurchase::where('productSeriesId', $value);
            $data[] = [
                'from' => date('Y-m-d', strtotime($list->orderBy('id', 'DESC')->first()->created_at)),
                'to' => date('Y-m-d', strtotime($list->latest()->first()->created_at)),
                'seriesId' => $list->first()->productSeriesId,
                'seriesName' => $list->first()->product_series->title,
                'count' => $list->count(),
            ];
        }
        return view('reports.bestSeller', compact('data', 'req', 'series'));
    }
}
