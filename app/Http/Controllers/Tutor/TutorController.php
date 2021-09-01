<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuitarSeries, Auth;
use App\Models\Category, App\Models\GuitarLession;
use App\Models\Genre;

class TutorController extends Controller
{
    /************************** Guitar Series *****************************/
    public function guitarSeriesView(Request $req)
    {
        $user = auth()->user();
        $guitarSeries = GuitarSeries::where('createdBy', $user->id)->get();
        return view('tutor.guitarSeries.index', compact('guitarSeries'));
    }

    public function guitarSeriesCreate(Request $req)
    {
        $category = Category::get();
        $genre = Genre::orderBy('name')->get();
        return view('tutor.guitarSeries.create', compact('category', 'genre'));
    }

    public function guitarSeriesSave(Request $req)
    {
        $req->validate([
            'category' => 'required|min:1|numeric',
            'image' => 'required|image',
            'title' => 'required|string|max:200',
            'media_link' => 'required|url',
            'description' => 'required|string',
            'gbp' => 'sometimes',
            'price_usd' => 'sometimes',
            'price_euro' => 'sometimes',
            'genre' => 'sometimes',
            'difficulty' => 'sometimes',
            'item_clean_url' => 'sometimes|url',
            'seo_meta_description' => 'sometimes',
            'seo_meta_keywords' => 'sometimes',
        ]);

        $newSeries = new GuitarSeries();
        $newSeries->categoryId = $req->category;
        $newSeries->title = $req->title;
        $newSeries->description = $req->description;
        $newSeries->gbp = $req->gbp;
        $newSeries->price_usd = $req->price_usd;
        $newSeries->price_euro = $req->price_euro;
        $newSeries->genre = $req->genre;
        $newSeries->difficulty = $req->difficulty;
        $newSeries->item_clean_url = $req->item_clean_url;
        $newSeries->seo_meta_description = $req->seo_meta_description;
        $newSeries->seo_meta_keywords = $req->seo_meta_keywords;

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $newSeries->image = imageUpload($image, 'guitar/series');
        }
        $newSeries->video_url = $req->media_link;
        $newSeries->createdBy = auth()->user()->id;
        $newSeries->save();
        return redirect(route('tutor.guitar.series'))->with('Success', 'Guitar Series Added SuccessFully');
    }

    public function guitarSeriesEdit(Request $req, $seriesId)
    {
        $category = Category::get();
        $genre = Genre::orderBy('name')->get();
        $user = auth()->user();
        $guitarSeries = GuitarSeries::where('id', $seriesId)->where('createdBy', $user->id)->first();
        return view('tutor.guitarSeries.edit', compact('category', 'guitarSeries', 'genre'));
    }

    public function guitarSeriesUpdate(Request $req, $seriesId)
    {
        $req->validate([
            'guitarSeriesId' => 'required|min:1|numeric|in:' . $seriesId,
            'category' => 'required|min:1|numeric',
            'image' => 'nullable|image',
            'title' => 'required|string|max:200',
            'media_link' => 'required|url',
            'description' => 'required|string',
            'gbp' => 'sometimes',
            'price_usd' => 'sometimes',
            'price_euro' => 'sometimes',
            'genre' => 'required',
            'difficulty' => 'sometimes',
            'item_clean_url' => 'sometimes|url',
            'seo_meta_description' => 'sometimes',
            'seo_meta_keywords' => 'sometimes',
        ]);

        $updateSeries = GuitarSeries::where('id', $seriesId)->first();
        $updateSeries->categoryId = $req->category;
        $updateSeries->title = $req->title;
        $updateSeries->description = $req->description;
        $updateSeries->gbp = $req->gbp;
        $updateSeries->price_usd = $req->price_usd;
        $updateSeries->price_euro = $req->price_euro;
        $updateSeries->genre = $req->genre;
        $updateSeries->difficulty = $req->difficulty;
        $updateSeries->item_clean_url = $req->item_clean_url;
        $updateSeries->seo_meta_description = $req->seo_meta_description;
        $updateSeries->seo_meta_keywords = $req->seo_meta_keywords;

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $updateSeries->image = imageUpload($image);
        }
        $updateSeries->video_url = $req->media_link;
        $updateSeries->save();
        return redirect(route('tutor.guitar.series'))->with('Success', 'Guitar Series Updated SuccessFully');
    }

    public function guitarSeriesDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $series = GuitarSeries::find($req->id);
            if ($series) {
                $series->delete();
                return successResponse('GuitarSeries Deleted Success');
            }
            return errorResponse('Invalid GuitarSeries Id');
        }
        return errorResponse($validator->errors()->first());
    }

    /****************************** Guitar Series Lession *******************************/
    public function guitarSeriesLessionView(Request $req, $seriesId)
    {
        $user = auth()->user();
        $guitarSeries = GuitarSeries::where('id', $seriesId)->where('createdBy', $user->id)->first();
        return view('tutor.guitarSeries.lession.index', compact('guitarSeries'));
    }

    public function guitarSeriesLessionCreate(Request $req, $seriesId)
    {
        $user = auth()->user();
        $genre = Genre::orderBy('name')->get();
        $guitarSeries = GuitarSeries::where('id', $seriesId)->where('createdBy', $user->id)->first();
        return view('tutor.guitarSeries.lession.create', compact('guitarSeries', 'genre'));
    }

    public function guitarSeriesLessionSave(Request $req, $seriesId)
    {
        $req->validate([
            'guitarSeriesId' => 'required|min:1|numeric|in:' . $seriesId,
            'title' => 'required|string|max:200',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'required|image',
            'gbp' => 'sometimes',
            'price_usd' => 'sometimes',
            'price_euro' => 'sometimes',
            'keywords' => 'required',
            'genre' => 'required',
            'item_clean_url' => 'required|url',
            'product_code' => 'required',
        ]);

        $series = GuitarSeries::where('id', $seriesId)->first();
        $newLession = new GuitarLession();
        $newLession->categoryId = $series->categoryId;
        $newLession->guitarSeriesId = $series->id;
        $newLession->title = $req->title;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $newLession->image = imageUpload($image, 'guitar/lession');
        }
        $newLession->currencyId = 3;
        $newLession->price = $req->price;
        $newLession->description = $req->description;
        $newLession->gbp = $req->gbp;
        $newLession->price_usd = $req->price_usd;
        $newLession->price_euro = $req->price_euro;
        $newLession->keywords = $req->keywords;
        $newLession->genre = $req->genre;
        $newLession->item_clean_url = $req->item_clean_url;
        $newLession->product_code = $req->product_code;
        $newLession->createdBy = auth()->user()->id;

        $newLession->save();
        return redirect(route('tutor.guitar.series.lession', $seriesId))->with('Success', 'Guitar Lession Added SuccessFully');
    }

    public function guitarSeriesLessionEdit(Request $req, $seriesId, $lessionId)
    {
        $user = auth()->user();
        $genre = Genre::orderBy('name')->get();
        $guitarLession = GuitarLession::where('id', $lessionId)->where('guitarSeriesId', $seriesId)->where('createdBy', $user->id)->first();
        return view('tutor.guitarSeries.lession.edit', compact('guitarLession', 'genre'));
    }

    public function guitarSeriesLessionUpdate(Request $req, $seriesId, $lessionId)
    {
        $req->validate([
            'guitarSeriesId' => 'required|min:1|numeric|in:' . $seriesId,
            'guitarLessionId' => 'required|min:1|numeric|in:' . $lessionId,
            'title' => 'required|string|max:200',
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'gbp' => 'nullable',
            'price_usd' => 'nullable',
            'price_euro' => 'nullable',
            'keywords' => 'nullable',
            'genre' => 'required',
            'item_clean_url' => 'required|url',
            'product_code' => 'nullable',
        ]);
        $updateLession = GuitarLession::where('id', $lessionId)->first();
        $updateLession->title = $req->title;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $updateLession->image = imageUpload($image, 'guitar/lession');
        }
        $updateLession->price = $req->price;
        $updateLession->description = $req->description;
        $updateLession->gbp = $req->gbp;
        $updateLession->price_usd = $req->price_usd;
        $updateLession->price_euro = $req->price_euro;
        $updateLession->keywords = $req->keywords;
        $updateLession->genre = $req->genre;
        $updateLession->item_clean_url = $req->item_clean_url;
        $updateLession->product_code = $req->product_code;

        $updateLession->save();
        return redirect(route('tutor.guitar.series.lession', $seriesId))->with('Success', 'Guitar Lession Updated SuccessFully');
    }

    public function guitarSeriesLessionDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $lession = GuitarLession::find($req->id);
            if ($lession) {
                $lession->delete();
                return successResponse('Guitar Lession Deleted Success');
            }
            return errorResponse('Invalid Guitar Lession Id');
        }
        return errorResponse($validator->errors()->first());
    }
}
