<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductSeries,App\Models\ProductSeriesLession;
use App\Models\Instrument;


class AdminController extends Controller
{
    public function dashboard(Request $req)
    {
        $data = (object)[];
        return view('admin.dashboard',compact('data'));
    }

    // Get Instrument by Providing InstrumentId
    public function getInstrument($instrumentId)
    {
        $instrument = Instrument::where('id',$instrumentId)->first();
        return $instrument;
    }

    public function productSeriesList(Request $req,$instrumentId)
    {
        $instrument = $this->getInstrument($instrumentId);
        if($instrument){
            $productSeries = ProductSeries::where('instrumentId',$instrument->id)->get();
            return view('admin.product.index',compact('productSeries','instrument'));
        }
        return abort(404);
    }

    public function productSeriesLessionList(Request $req,$instrumentId,$seriesId)
    {
        $instrument = $this->getInstrument($instrumentId);
        if($instrument){
            $productSeries = ProductSeries::where('id',$seriesId)->where('instrumentId',$instrumentId)->first();
            if($productSeries){
                $productSeries->lession_data = ProductSeriesLession::where('instrumentId',$instrument->id)->where('categoryId',$productSeries->categoryId)->where('productSeriesId',$productSeries->id)->get();
                return view('admin.product.lession.index',compact('productSeries','instrument'));
            }
        }
        return abort(404);   
    }
}
