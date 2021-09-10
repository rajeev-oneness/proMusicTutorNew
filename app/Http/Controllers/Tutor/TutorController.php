<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category,Auth;
use App\Models\ProductSeries,App\Models\ProductSeriesLession;
use App\Models\Genre;

class TutorController extends Controller
{
    /************************** Product Series *****************************/
    public function productSeriesView(Request $req)
    {
        $user = auth()->user();
        $productSeries = ProductSeries::where('createdBy', $user->id)->get();
        return view('tutor.productSeries.index', compact('productSeries'));
    }

    public function productSeriesCreate(Request $req)
    {
        $category = Category::get();
        $genre = Genre::orderBy('name')->get();
        return view('tutor.productSeries.create', compact('category', 'genre'));
    }

    public function productSeriesSave(Request $req)
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

        $newSeries = new ProductSeries();
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
            $newSeries->image = imageUpload($image, 'product/series');
        }
        $newSeries->video_url = $req->media_link;
        $newSeries->createdBy = auth()->user()->id;
        $newSeries->save();
        return redirect(route('tutor.product.series'))->with('Success', 'Product Series Added SuccessFully');
    }

    public function productSeriesEdit(Request $req, $seriesId)
    {
        $category = Category::get();
        $genre = Genre::orderBy('name')->get();
        $user = auth()->user();
        $productSeries = ProductSeries::where('id', $seriesId)->where('createdBy', $user->id)->first();
        return view('tutor.productSeries.edit', compact('category', 'productSeries', 'genre'));
    }

    public function productSeriesUpdate(Request $req, $seriesId)
    {
        $req->validate([
            'productSeriesId' => 'required|min:1|numeric|in:' . $seriesId,
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

        $updateSeries = ProductSeries::where('id', $seriesId)->first();
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
        return redirect(route('tutor.product.series'))->with('Success', 'Product Series Updated SuccessFully');
    }

    public function productSeriesDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $series = ProductSeries::find($req->id);
            if ($series) {
                $series->delete();
                return successResponse('ProductSeries Deleted Success');
            }
            return errorResponse('Invalid ProductSeries Id');
        }
        return errorResponse($validator->errors()->first());
    }

    /****************************** Product Series Lession *******************************/
    public function productSeriesLessionView(Request $req, $seriesId)
    {
        $user = auth()->user();
        $productSeries = ProductSeries::where('id', $seriesId)->where('createdBy', $user->id)->first();
        return view('tutor.productSeries.lession.index', compact('productSeries'));
    }

    public function productSeriesLessionCreate(Request $req, $seriesId)
    {
        $user = auth()->user();
        $genre = Genre::orderBy('name')->get();
        $productSeries = ProductSeries::where('id', $seriesId)->where('createdBy', $user->id)->first();
        return view('tutor.productSeries.lession.create', compact('productSeries', 'genre'));
    }

    public function productSeriesLessionSave(Request $req, $seriesId)
    {
        $req->validate([
            'productSeriesId' => 'required|min:1|numeric|in:' . $seriesId,
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

        $series = ProductSeries::where('id', $seriesId)->first();
        $newLession = new ProductSeriesLession();
        $newLession->categoryId = $series->categoryId;
        $newLession->productSeriesId = $series->id;
        $newLession->title = $req->title;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $newLession->image = imageUpload($image, 'product/lession');
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
        return redirect(route('tutor.product.series.lession', $seriesId))->with('Success', 'Product Lession Added SuccessFully');
    }

    public function productSeriesLessionEdit(Request $req, $seriesId, $lessionId)
    {
        $user = auth()->user();
        $genre = Genre::orderBy('name')->get();
        $productLession = ProductSeriesLession::where('id', $lessionId)->where('productSeriesId', $seriesId)->where('createdBy', $user->id)->first();
        return view('tutor.productSeries.lession.edit', compact('productLession', 'genre'));
    }

    public function productSeriesLessionUpdate(Request $req, $seriesId, $lessionId)
    {
        $req->validate([
            'productSeriesId' => 'required|min:1|numeric|in:' . $seriesId,
            'productLessionId' => 'required|min:1|numeric|in:' . $lessionId,
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
        $updateLession = ProductSeriesLession::where('id', $lessionId)->first();
        $updateLession->title = $req->title;
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $updateLession->image = imageUpload($image, 'product/lession');
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
        return redirect(route('tutor.product.series.lession', $seriesId))->with('Success', 'Product Series Lession Updated SuccessFully');
    }

    public function productSeriesLessionDelete(Request $req)
    {
        $rules = [
            'id' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $lession = ProductSeriesLession::find($req->id);
            if ($lession) {
                $lession->delete();
                return successResponse('Product Series Lession Deleted Success');
            }
            return errorResponse('Invalid Product Series Lession Id');
        }
        return errorResponse($validator->errors()->first());
    }
}
