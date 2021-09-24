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

    public function mostViewed(Request $req)
    {
        $series = ProductSeries::where('view_count', '>', 0);

        if (!empty($req->instrumentId)) {
            $series = $series->where('instrumentId', $req->instrumentId);
        }
        if (!empty($req->dateFrom)) {
            $series = $series->where('created_at', '>=', $req->dateFrom);
        }
        if (!empty($req->dateTo)) {
            $series = $series->where('last_count_increased_at', '<=', date('Y-m-d', strtotime($req->dateTo . '+ 1 day')));
        }

        $series = $series->orderBy('view_count', 'desc')->get();

        $instruments = Instrument::all();
        return view('reports.mostViewed', compact('req', 'series', 'instruments'));
    }

    public function productsOrdered(Request $req)
    {
        $data = [];
        $purchaseList = UserProductLessionPurchase::select('productSeriesLessionId');
        $series = $purchaseList->groupBy('productSeriesLessionId')->get();

        if ($req->instrumentId) {
            $purchaseList = $purchaseList->join('product_series_lessions', 'product_series_lessions.id', '=', 'user_product_lession_purchases.productSeriesLessionId')
            ->join('instruments', 'instruments.id', '=', 'product_series_lessions.instrumentId')
            ->where('instruments.id', $req->instrumentId);
        }
        if (!empty($req->dateFrom)) {
            $purchaseList = $purchaseList->where('user_product_lession_purchases.created_at', '>=', $req->dateFrom);
        }
        if (!empty($req->dateTo)) {
            $purchaseList = $purchaseList->where('user_product_lession_purchases.created_at', '<=', date('Y-m-d', strtotime($req->dateTo . '+ 1 day')));
        }

        $purchaseList = $purchaseList->groupBy('productSeriesLessionId')->pluck('productSeriesLessionId')->toArray();

        foreach ($purchaseList as $key => $value) {
            $list = UserProductLessionPurchase::where('productSeriesLessionId', $value);
            $data[] = [
                'from' => date('Y-m-d', strtotime($list->orderBy('id', 'DESC')->first()->created_at)),
                'to' => date('Y-m-d', strtotime($list->latest()->first()->created_at)),
                'seriesId' => $list->first()->productSeriesLessionId,
                'lessonName' => $list->first()->product_series_lession->title,
                'count' => $list->count(),
            ];
        }

        $instruments = Instrument::all();
        return view('reports.productsOrdered', compact('data', 'req', 'instruments'));
    }
}
