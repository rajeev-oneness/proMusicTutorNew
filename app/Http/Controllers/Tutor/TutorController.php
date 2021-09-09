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
            'gbp' => 'nullable|min:1|numeric',
            'price_usd' => 'nullable|min:1|numeric',
            'price_euro' => 'nullable|min:1|numeric',
            'genre' => 'nullable|min:1',
            'difficulty' => 'required',
            'item_clean_url' => 'nullable|url',
            'seo_meta_description' => 'nullable',
            'seo_meta_keywords' => 'nullable',
        ]);

        $newSeries = new GuitarSeries();
        $newSeries->categoryId = $req->category;
        $newSeries->title = $req->title;
        $newSeries->description = $req->description;
        $newSeries->difficulty = $req->difficulty;
        $newSeries->gbp = !empty($req->gbp) ? $req->gbp : 0;
        $newSeries->price_usd = !empty($req->price_usd) ? $req->price_usd : 0;
        $newSeries->price_euro = !empty($req->price_euro) ? $req->price_euro : 0;
        $newSeries->genre = !empty($req->genre) ? $req->genre : 0;
        $newSeries->item_clean_url = emptyCheck($req->item_clean_url);
        $newSeries->seo_meta_description = emptyCheck($req->seo_meta_description);
        $newSeries->seo_meta_keywords = emptyCheck($req->seo_meta_keywords);

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
            'gbp' => 'nullable|min:1|numeric',
            'price_usd' => 'nullable|min:1|numeric',
            'price_euro' => 'nullable|min:1|numeric',
            'genre' => 'nullable|min:1',
            'difficulty' => 'required',
            'item_clean_url' => 'nullable|url',
            'seo_meta_description' => 'nullable',
            'seo_meta_keywords' => 'nullable',
        ]);

        $updateSeries = GuitarSeries::where('id', $seriesId)->first();
        $updateSeries->categoryId = $req->category;
        $updateSeries->title = $req->title;
        $updateSeries->description = $req->description;
        $updateSeries->difficulty = $req->difficulty;
        $updateSeries->gbp = !empty($req->gbp) ? $req->gbp : 0;
        $updateSeries->price_usd = !empty($req->price_usd) ? $req->price_usd : 0;
        $updateSeries->price_euro = !empty($req->price_euro) ? $req->price_euro : 0;
        $updateSeries->genre = !empty($req->genre) ? $req->genre : 0;
        $updateSeries->item_clean_url = emptyCheck($req->item_clean_url);
        $updateSeries->seo_meta_description = emptyCheck($req->seo_meta_description);
        $updateSeries->seo_meta_keywords = emptyCheck($req->seo_meta_keywords);
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
            'gbp' => 'nullable|min:1|numeric',
            'price_usd' => 'nullable|min:1|numeric',
            'price_euro' => 'nullable|min:1|numeric',
            'keywords' => 'nullable|max:255',
            'genre' => 'required|min:1|numeric',
            'item_clean_url' => 'nullable|url',
            'product_code' => 'nullable',
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
        $newLession->gbp = !empty($req->gbp) ? $req->gbp : 0;
        $newLession->price_usd = !empty($req->price_usd) ? $req->price_usd : 0;
        $newLession->price_euro = !empty($req->price_euro) ? $req->price_euro : 0;
        $newLession->keywords = emptyCheck($req->keywords);
        $newLession->genre = !empty($req->genre) ? $req->genre : 0;
        $newLession->item_clean_url = emptyCheck($req->item_clean_url);
        $newLession->product_code = emptyCheck($req->product_code);
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
            'gbp' => 'nullable|min:1|numeric',
            'price_usd' => 'nullable|min:1|numeric',
            'price_euro' => 'nullable|min:1|numeric',
            'keywords' => 'nullable|max:255',
            'genre' => 'required|min:1|numeric',
            'item_clean_url' => 'nullable|url',
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
        $updateLession->gbp = !empty($req->gbp) ? $req->gbp : 0;
        $updateLession->price_usd = !empty($req->price_usd) ? $req->price_usd : 0;
        $updateLession->price_euro = !empty($req->price_euro) ? $req->price_euro : 0;
        $updateLession->keywords = emptyCheck($req->keywords);
        $updateLession->genre = !empty($req->genre) ? $req->genre : 0;
        $updateLession->item_clean_url = emptyCheck($req->item_clean_url);
        $updateLession->product_code = emptyCheck($req->product_code);
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
