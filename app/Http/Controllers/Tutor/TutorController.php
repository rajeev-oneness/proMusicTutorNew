<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request,DB;
use App\Models\Instrument;
use App\Models\Offer,App\Models\OfferSeries;
use App\Models\ProductSeries;

class TutorController extends Controller
{
    public function dashboard(Request $req)
    {
        $tutor = $req->user();
        $data = (object)[];
        $data->instrument = Instrument::get();
        foreach ($data->instrument as $key => $instrument) {
            $instrument->product = ProductSeries::where('instrumentId',$instrument->id)->where('createdBy',$tutor->id)->get();
        }
        return view('tutor.dashboard',compact('data'));
    }

    public function offersList(Request $req)
    {
        $tutor = $req->user();
        $offers = Offer::where('createdBy',$tutor->id)->get();
        return view('tutor.offer.list', compact('offers'));
    }

    public function offerCreate(Request $req)
    {
        $tutor = $req->user();
        $series = ProductSeries::where('createdBy',$tutor->id)->get();
        return view('tutor.offer.create', compact('series'));
    }

    public function offerStore(Request $req)
    {
        $req->validate([
            'image' => 'required',
            'title' => 'required|string|max:255',
            'price_gbp' => 'required|numeric|min:1',
            'price_usd' => 'required|numeric|min:1',
            'price_eur' => 'required|numeric|min:1',
            'description' => 'required|string',
            'offer_description' => 'required|string',
            'seriesId' => 'required|array',
            'seriesId.*' => 'required|numeric|min:1',
        ]);
        DB::beginTransaction();
        try {
            $offers = new Offer();
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $offers->image = imageUpload($image, 'offer');
            }
            $offers->title = strQuotationCheck($req->title);
            $offers->price_usd = $req->price_usd;
            $offers->price_euro = $req->price_eur;
            $offers->price_gbp = $req->price_gbp;
            $offers->description = strQuotationCheck($req->description);
            $offers->offer_description = strQuotationCheck($req->offer_description);
            $offers->createdBy = auth()->user()->id;
            $offers->save();
            if (!empty($req->seriesId) && count($req->seriesId) > 0) {
                foreach ($req->seriesId as $key => $series) {
                    $offerSeries = new OfferSeries();
                    $offerSeries->offer_id = $offers->id;
                    $offerSeries->series_id = $series;
                    $offerSeries->save();
                }
            }
            DB::commit();
            return redirect()->route('tutor.offer.list')->with('Success', 'Offer Added successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            $errors['title'] = 'Something went wrong please try after sometime';
            return back()->withInput($req->all())->withErrors($errors);
        }
    }

    public function offerEdit(Request $req, $id)
    {
        $tutor = $req->user();
        $offer = Offer::where('id',$id)->where('createdBy',$tutor->id)->first();
        if($offer){
            $series = ProductSeries::where('createdBy',$tutor->id)->get();
            return view('tutor.offer.edit', compact('series', 'offer'));    
        }
        return redirect()->route('tutor.offer.list')->with('Errors', 'Something went wrong please try after sometime');
    }

    public function offerUpdate(Request $req, $offerId)
    {
        $req->validate([
            'image' => 'nullable',
            'title' => 'required|string|max:255',
            'price_gbp' => 'required|numeric|min:1',
            'price_usd' => 'required|numeric|min:1',
            'price_eur' => 'required|numeric|min:1',
            'description' => 'required|string',
            'offer_description' => 'required|string',
            'seriesId' => 'required|array',
            'seriesId.*' => 'required|numeric|min:1',
        ]);
        DB::beginTransaction();
        try {
            $tutor = $req->user();
            $offers = Offer::where('id',$offerId)->where('createdBy',$tutor->id)->first();
            if($offers){
                if ($req->hasFile('image')) {
                    $image = $req->file('image');
                    $offers->image = imageUpload($image, 'offer');
                }
                $offers->title = strQuotationCheck($req->title);
                $offers->price_usd = $req->price_usd;
                $offers->price_euro = $req->price_eur;
                $offers->price_gbp = $req->price_gbp;
                $offers->description = strQuotationCheck($req->description);
                $offers->offer_description = strQuotationCheck($req->offer_description);
                $offers->save();
                if (!empty($req->seriesId) && count($req->seriesId) > 0) {
                    OfferSeries::where('offer_id', $offers->id)->delete();
                    foreach ($req->seriesId as $key => $series) {
                        $offerSeries = new OfferSeries();
                        $offerSeries->offer_id = $offers->id;
                        $offerSeries->series_id = $series;
                        $offerSeries->save();
                    }
                }
                DB::commit();
                return redirect()->route('tutor.offer.list')->with('Success', 'Offer Updated successfully');
            }
        } catch (\Throwable $th) {
            DB::rollback();
        }
        $errors['title'] = 'Something went wrong please try after sometime';
        return back()->withInput($req->all())->withErrors($errors);
    }

    public function offerDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
            'userId' => 'required|min:1|numeric',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $offer = Offer::where('id',$req->id)->where('createdBy',$req->userId);
            if ($offer) {
                $offer->delete();
                return successResponse('Offer Plan deleted successfully');
            }
            return errorResponse('Invalid Offer Id');
        }
        return errorResponse($validator->errors()->first());
    }
}
