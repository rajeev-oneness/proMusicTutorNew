<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request,DB;
use App\Models\Instrument;
use App\Models\Offer,App\Models\OfferSeries;
use App\Models\ProductSeries;
use App\Models\UserProductLessionPurchase;

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
        $data->offers = Offer::where('createdBy',$tutor->id)->get();
        /***************** Most Viewed Series ****************/
        $data->mostViewed = ProductSeries::where('view_count', '>', 0)->where('createdBy',$tutor->id);
            if (!empty($req->mostViewedInstrumentId)) {
                $data->mostViewed = $data->mostViewed->where('instrumentId', $req->mostViewedInstrumentId);
            }
            if (!empty($req->mostViewedDateFrom)) {
                $data->mostViewed = $data->mostViewed->where('created_at', '>=', $req->mostViewedDateFrom);
            }
            if (!empty($req->mostViewedDateTo)) {
                $data->mostViewed = $data->mostViewed->where('last_count_increased_at', '<=', date('Y-m-d', strtotime($req->mostViewedDateTo . '+ 1 day')));
            }
        $data->mostViewed = $data->mostViewed->orderBy('view_count', 'desc')->paginate(8);
        /***************** Most Viewed Series End****************/
        /***************** Transaction Log ****************/
        $transactionLogData = [];
        $userPurchaseTransaction = UserProductLessionPurchase::where('authorId',$tutor->id)->groupBy(['transactionId'])->latest()->paginate(8);
        foreach ($userPurchaseTransaction as $key => $userTrasaction) {
            $offersTransaction = UserProductLessionPurchase::with('offers_details_all')->where('authorId',$tutor->id)->where('transactionId',$userTrasaction->transactionId)->where('type_of_product','offer')->groupBy('offerId')->get();
            $seriesTransaction = UserProductLessionPurchase::with('product_series_all')->where('authorId',$tutor->id)->where('transactionId',$userTrasaction->transactionId)->where('type_of_product','series')->groupBy('productSeriesId')->get();
            $lessionsTransaction = UserProductLessionPurchase::with('product_series_lession_all')->where('authorId',$tutor->id)->where('transactionId',$userTrasaction->transactionId)->where('type_of_product','lession')->groupBy('productSeriesLessionId')->get();
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
        return view('tutor.dashboard',compact('data','req'));
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
            $tutor = $req->user();
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
