<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuitarSeries,App\Models\GuitarLession;


class AdminController extends Controller
{
    public function guitarSeriesList(Request $req)
    {
    	$guitarSeries = GuitarSeries::get();
    	return view('admin.guitar.index',compact('guitarSeries'));
    }

    public function guitarLessionList(Request $req,$seriesId)
    {
    	$guitarSeries = GuitarSeries::where('id',$seriesId)->first();
    	return view('admin.guitar.lession.index',compact('guitarSeries'));
    }
}
