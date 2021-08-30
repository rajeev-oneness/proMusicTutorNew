<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuitarSeries,Auth;
use App\Models\Category,App\Models\GuitarLession;

class TutorController extends Controller
{
    /************************** Guitar Series *****************************/
    public function guitarSeriesView(Request $req)
    {
        $user = auth()->user();
        $guitarSeries = GuitarSeries::where('createdBy',$user->id)->get();
        return view('tutor.guitarSeries.index',compact('guitarSeries'));
    }

    public function guitarSeriesCreate(Request $req)
    {
        $category = Category::get();
        return view('tutor.guitarSeries.create',compact('category'));
    }

    public function guitarSeriesSave(Request $req)
    {
        $req->validate([
            'category' => 'required|min:1|numeric',
            'image' => 'required|image',
            'title' => 'required|string|max:200',
            'media_link' => 'required|url',
            'description' => 'required|string',
        ]);
        $newSeries = new GuitarSeries();
        $newSeries->categoryId = $req->category;
        $newSeries->title = $req->title;
        $newSeries->description = $req->description;
        if($req->hasFile('image')){
            $image = $req->file('image');
            $newSeries->image = imageUpload($image);
        }
        $newSeries->video_url = $req->media_link;
        $newSeries->createdBy = auth()->user()->id;
        $newSeries->save();
        return redirect(route('tutor.guitar.series'))->with('Success','Guitar Series Added SuccessFully');
    }

    public function guitarSeriesEdit(Request $req,$seriesId)
    {
        $category = Category::get();$user = auth()->user();
        $guitarSeries = GuitarSeries::where('id',$seriesId)->where('createdBy',$user->id)->first();
        return view('tutor.guitarSeries.edit',compact('category','guitarSeries'));
    }

    public function guitarSeriesUpdate(Request $req,$seriesId)
    {
        $req->validate([
            'guitarSeriesId' => 'required|min:1|numeric|in:'.$seriesId,
            'category' => 'required|min:1|numeric',
            'image' => 'nullable|image',
            'title' => 'required|string|max:200',
            'media_link' => 'required|url',
            'description' => 'required|string',
        ]);
        $updateSeries = GuitarSeries::where('id',$seriesId)->first();
        $updateSeries->categoryId = $req->category;
        $updateSeries->title = $req->title;
        $updateSeries->description = $req->description;
        if($req->hasFile('image')){
            $image = $req->file('image');
            $updateSeries->image = imageUpload($image);
        }
        $updateSeries->video_url = $req->media_link;
        $updateSeries->save();
        return redirect(route('tutor.guitar.series'))->with('Success','Guitar Series Updated SuccessFully');
    }

    public function guitarSeriesDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $series = GuitarSeries::find($req->id);
            if($series){
                $series->delete();
                return successResponse('GuitarSeries Deleted Success');  
            }
            return errorResponse('Invalid GuitarSeries Id');
        }
        return errorResponse($validator->errors()->first());
    }

    /****************************** Guitar Series Lession *******************************/
    public function guitarSeriesLessionView(Request $req,$seriesId)
    {
        $user = auth()->user();
        $guitarSeries = GuitarSeries::where('id',$seriesId)->where('createdBy',$user->id)->first();
        return view('tutor.guitarSeries.lession.index',compact('guitarSeries'));
    }

    public function guitarSeriesLessionCreate(Request $req,$seriesId)
    {
        $user = auth()->user();
        $guitarSeries = GuitarSeries::where('id',$seriesId)->where('createdBy',$user->id)->first();
        return view('tutor.guitarSeries.lession.create',compact('guitarSeries'));
    }

    public function guitarSeriesLessionSave(Request $req,$seriesId)
    {
        $req->validate([
            'guitarSeriesId' => 'required|min:1|numeric|in:'.$seriesId,
            'title' => 'required|string|max:200',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'required|image',
        ]);
        $series = GuitarSeries::where('id',$seriesId)->first();
        $newLession = new GuitarLession();
            $newLession->categoryId = $series->categoryId;
            $newLession->guitarSeriesId = $series->id;
            $newLession->title = $req->title;
            if($req->hasFile('image')){
                $image = $req->file('image');
                $newLession->image = imageUpload($image,'guitar/lession');
            }
            $newLession->currencyId = 3;
            $newLession->price = $req->price;
            $newLession->description = $req->description;
            $newLession->createdBy = auth()->user()->id;
        $newLession->save();
        return redirect(route('tutor.guitar.series.lession',$seriesId))->with('Success','Guitar Lession Added SuccessFully');
    }

    public function guitarSeriesLessionEdit(Request $req,$seriesId,$lessionId)
    {
        $user = auth()->user();
        $guitarLession = GuitarLession::where('id',$lessionId)->where('guitarSeriesId',$seriesId)->where('createdBy',$user->id)->first();
        return view('tutor.guitarSeries.lession.edit',compact('guitarLession'));
    }

    public function guitarSeriesLessionUpdate(Request $req,$seriesId,$lessionId)
    {
        $req->validate([
            'guitarSeriesId' => 'required|min:1|numeric|in:'.$seriesId,
            'guitarLessionId' => 'required|min:1|numeric|in:'.$lessionId,
            'title' => 'required|string|max:200',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image',
        ]);
        $updateLession = new GuitarLession();
            $updateLession->title = $req->title;
            if($req->hasFile('image')){
                $image = $req->file('image');
                $updateLession->image = imageUpload($image,'guitar/lession');
            }
            $updateLession->price = $req->price;
            $updateLession->description = $req->description;
        $updateLession->save();
        return redirect(route('tutor.guitar.series.lession',$seriesId))->with('Success','Guitar Lession Updated SuccessFully');
    }

    public function guitarSeriesLessionDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(),$rules);
        if(!$validator->fails()){
            $lession = GuitarLession::find($req->id);
            if($lession){
                $lession->delete();
                return successResponse('Guitar Lession Deleted Success');
            }
            return errorResponse('Invalid Guitar Lession Id');
        }
        return errorResponse($validator->errors()->first());
    }
}
