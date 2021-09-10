<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSeries,App\Models\ProductSeriesLession;


class AdminController extends Controller
{
    public function productSeriesList(Request $req)
    {
    	$productSeries = ProductSeries::get();
    	return view('admin.product.index',compact('productSeries'));
    }

    public function productLessionList(Request $req,$seriesId)
    {
    	$productSeries = ProductSeries::where('id',$seriesId)->first();
    	return view('admin.product.lession.index',compact('productSeries'));
    }
}
