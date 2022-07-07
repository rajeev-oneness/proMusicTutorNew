<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category, Auth;
use App\Models\ProductSeries, App\Models\ProductSeriesLession;
use App\Models\Instrument, App\Models\Genre, App\Models\User;
use App\Models\Blog,App\Models\BlogCategory,App\Models\BlogTag;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $req)
    {
        $data = (object)[];
        $data->instruments = Instrument::latest()->get();
        $data->categories = Category::latest()->get();
        $data->genres = Genre::latest()->get();
        $data->tutors = User::select('*')->where('user_type',2)->get();
        $data->students = User::select('*')->where('user_type',3)->get();
        $data->blogTags = BlogTag::select('*')->latest()->get();
        $data->blogs = Blog::select('*')->latest()->get();
        $data->blogCategory = BlogCategory::select('*')->latest()->get();

        /* $data->salesReport = DB::select('SELECT up.created_at AS time, SUM(l.price_gbp) AS price_gbp, SUM(l.price_usd) AS price_usd, SUM(l.price_euro) AS price_euro FROM `user_product_lession_purchases` AS up 
        INNER JOIN product_series_lessions AS l 
        ON up.productSeriesLessionId = l.id 
        GROUP BY MONTH(up.created_at) 
        ORDER BY up.created_at ASC 
        LIMIT 10'); */

        $data->salesReport = DB::select('SELECT created_at AS time, SUM(amount/100) AS price, currency FROM `transactions` AS t 
        GROUP BY MONTH(created_at), currency 
        ORDER BY created_at ASC 
        LIMIT 12 
        ');

        // dd($data->salesReport );

        return view('admin.dashboard', compact('data'));
    }

    // Get Instrument by Providing InstrumentId
    public function getInstrument($instrumentId)
    {
        $instrument = Instrument::where('id', $instrumentId)->first();
        return $instrument;
    }

    // SERIES - VIEW
    public function productSeriesList(Request $req, $instrumentId)
    {
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $productSeries = ProductSeries::where('instrumentId', $instrument->id)->get();
            return view('admin.product.index', compact('productSeries', 'instrument'));
        }
        return abort(404);
    }

    // SERIES - CREATE
    public function productSeriesCreate(Request $req, $instrumentId)
    {
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $category = Category::where('instrumentId', $instrument->id)->get();
            $genre = Genre::orderBy('name')->get();
            $tutors = User::where('user_type', 2)->orderBy('name')->get();
            return view('admin.product.create', compact('category', 'instrument', 'genre', 'tutors'));
        }
        return abort(404);
    }

    // SERIES - SAVE
    public function productSeriesSave(Request $req, $instrumentId)
    {
        $req->validate([
            'createdBy' => 'required|numeric|min:1',
            'instrumentId' => 'required|min:1|numeric|in:' . $instrumentId,
            'category' => 'required|min:1|numeric',
            'image' => 'nullable|image',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'media_link' => 'nullable',
            'difficulty' => 'required|string|in:Easy,Medium,Hard',
            'genre' => 'required|min:1|numeric',
            'price_gbp' => 'nullable|min:1|numeric',
            'price_usd' => 'nullable|min:1|numeric',
            'price_euro' => 'nullable|min:1|numeric',
            'item_clean_url' => 'nullable|url',
            'seo_meta_description' => 'nullable|string',
            'seo_meta_keywords' => 'nullable|string|max:255',
        ]);

        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $newSeries = new ProductSeries();
            $newSeries->instrumentId = $instrument->id;
            $newSeries->categoryId = $req->category;
            $newSeries->title = $req->title;
            $newSeries->difficulty = $req->difficulty;
            $newSeries->description = emptyCheck($req->description);
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $newSeries->image = imageUpload($image, 'product/series');
            }
            if ($req->hasFile('media_link')) {
                $media_link = $req->file('media_link');
                $newSeries->video_url = imageUpload($media_link, 'product/series');
            }
            // $newSeries->video_url = $req->media_link;
            $newSeries->createdBy = $req->createdBy;
            // New Addition
            $newSeries->genre = !empty($req->genre) ? $req->genre : 0;
            $newSeries->price_gbp = !empty($req->price_gbp) ? $req->price_gbp : 0;
            $newSeries->price_usd = !empty($req->price_usd) ? $req->price_usd : 0;
            $newSeries->price_euro = !empty($req->price_euro) ? $req->price_euro : 0;
            $newSeries->item_clean_url = emptyCheck($req->item_clean_url);
            $newSeries->seo_meta_description = emptyCheck($req->seo_meta_description);
            $newSeries->seo_meta_keywords = emptyCheck($req->seo_meta_keywords);
            $newSeries->save();
            return redirect(route('admin.product.series.list', [$instrumentId]))->with('Success', 'Product Series Added SuccessFully');
        }
        return abort(404);
    }

    // SERIES - EDIT
    public function productSeriesEdit(Request $req, $instrumentId, $seriesId)
    {
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $category = Category::where('instrumentId', $instrument->id)->get();
            $user = $req->user();
            $genre = Genre::orderBy('name')->get();
            $productSeries = ProductSeries::where('id', $seriesId)->where('instrumentId', $instrument->id)->first();
            $tutors = User::where('user_type', 2)->orderBy('name')->get();
            return view('admin.product.edit', compact('category', 'instrument', 'productSeries', 'genre', 'tutors'));
        }
        return abort(404);
    }

    // SERIES - SAVE
    public function productSeriesUpdate(Request $req, $instrumentId, $seriesId)
    {
        $req->validate([
            'productSeriesId' => 'required|min:1|numeric|in:' . $seriesId,
            'instrumentId' => 'required|min:1|numeric|in:' . $instrumentId,
            'createdBy' => 'required|min:1|numeric',
            'category' => 'required|min:1|numeric',
            'image' => 'nullable|image',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'media_link' => 'nullable',
            'difficulty' => 'required|string|in:Easy,Medium,Hard',
            'genre' => 'required|min:1|numeric',
            'price_gbp' => 'nullable|min:1|numeric',
            'price_usd' => 'nullable|min:1|numeric',
            'price_euro' => 'nullable|min:1|numeric',
            'item_clean_url' => 'nullable|url',
            'seo_meta_description' => 'nullable|string',
            'seo_meta_keywords' => 'nullable|string|max:255',
        ]);
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $updateSeries = ProductSeries::where('id', $seriesId)->first();
            $updateSeries->instrumentId = $instrument->id;
            $updateSeries->categoryId = $req->category;
            $updateSeries->createdBy = $req->createdBy;
            $updateSeries->title = $req->title;
            $updateSeries->description = emptyCheck($req->description);
            $updateSeries->difficulty = $req->difficulty;
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $updateSeries->image = imageUpload($image, 'product/series');
            }
            if ($req->hasFile('media_link')) {
                $media_link = $req->file('media_link');
                $updateSeries->video_url = imageUpload($media_link, 'product/series');
            }
            // $updateSeries->video_url = $req->media_link;
            // New Addition
            $updateSeries->genre = !empty($req->genre) ? $req->genre : 0;
            $updateSeries->price_gbp = !empty($req->price_gbp) ? $req->price_gbp : 0;
            $updateSeries->price_usd = !empty($req->price_usd) ? $req->price_usd : 0;
            $updateSeries->price_euro = !empty($req->price_euro) ? $req->price_euro : 0;
            $updateSeries->item_clean_url = emptyCheck($req->item_clean_url);
            $updateSeries->seo_meta_description = emptyCheck($req->seo_meta_description);
            $updateSeries->seo_meta_keywords = emptyCheck($req->seo_meta_keywords);
            $updateSeries->save();
            return redirect(route('admin.product.series.list', [$instrumentId]))->with('Success', 'Product Series Updated SuccessFully');
        }
        return abort(404);
    }

    // SERIES - DELETE
    public function productSeriesDelete(Request $req)
    {
        $rules = [
            'instrumentId' => 'required|numeric|min:1',
            'productSeriesId' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $productSeries = ProductSeries::where('id', $req->productSeriesId)->where('instrumentId', $req->instrumentId)->first();
            if ($productSeries) {
                ProductSeriesLession::where('productSeriesId', $productSeries->id)->where('instrumentId', $req->instrumentId)->delete();
                $productSeries->delete();
                return successResponse('Series Deleted Success');
            }
            return errorResponse('You donot have permission to delete');
        }
        return errorResponse($validator->errors()->first());
    }

    // LESSON - VIEW
    public function productSeriesLessionList(Request $req, $instrumentId, $seriesId)
    {
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $productSeries = ProductSeries::where('id', $seriesId)->where('instrumentId', $instrumentId)->first();
            if ($productSeries) {
                $productSeries->lession_data = ProductSeriesLession::where('instrumentId', $instrument->id)->where('categoryId', $productSeries->categoryId)->where('productSeriesId', $productSeries->id)->get();
                return view('admin.product.lession.index', compact('productSeries', 'instrument'));
            }
        }
        return abort(404);
    }

    // LESSON - CREATE
    public function productSeriesLessionCreate(Request $req, $instrumentId, $seriesId)
    {
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $user = $req->user();
            $genre = Genre::orderBy('name')->get();
            $productSeries = ProductSeries::where('id', $seriesId)->first();
            $tutors = User::where('user_type', 2)->orderBy('name')->get();
            return view('admin.product.lession.create', compact('instrument', 'productSeries', 'genre', 'tutors'));
        }
        return abort(404);
    }

    // LESSON - SAVE
    public function productSeriesLessionSave(Request $req, $instrumentId, $productSeriesId)
    {
        $req->validate([
            'instrumentId' => 'required|min:1|numeric|in:' . $instrumentId,
            'productSeriesId' => 'required|min:1|numeric|in:' . $productSeriesId,
            'title' => 'required|string|max:200',
            'difficulty' => 'required|string|in:Easy,Medium,Hard',
            // 'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'required|image',
            // 'preview_video' => 'required|mimes:mp4, 3gp, mkv, avi, flv, wmv, webm, ogx, oga, ogv, ogg, mov, m3u8, ts',
            'preview_video' => 'nullable',
            'video_url' => 'nullable',
            'price_gbp' => 'nullable|min:1|numeric',
            'price_usd' => 'nullable|min:1|numeric',
            'price_euro' => 'nullable|min:1|numeric',
            'keywords' => 'nullable|max:255',
            'genre' => 'nullable|min:1|numeric',
            'item_clean_url' => 'nullable|url',
            'product_code' => 'nullable',
        ]);

        // dd($req->all());
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $user = $req->user();
            $productSeries = ProductSeries::where('id', $productSeriesId)->where('instrumentId', $instrument->id)->first();
            if ($productSeries) {
                $newLession = new ProductSeriesLession();
                $newLession->instrumentId = $instrument->id;
                $newLession->categoryId = $productSeries->categoryId;
                $newLession->productSeriesId = $productSeries->id;
                $newLession->title = $req->title;
                $newLession->difficulty = $req->difficulty;
                if ($req->hasFile('image')) {
                    $image = $req->file('image');
                    $newLession->image = imageUpload($image, 'product/lession');
                }
                if ($req->hasFile('preview_video')) {
                    $preview_video = $req->file('preview_video');
                    $newLession->preview_video = imageUpload($preview_video, 'product/lession/video');
                }
                if ($req->hasFile('video_url')) {
                    $video = $req->file('video_url');
                    $newLession->video = imageUpload($video, 'product/lession/video');
                }
                $newLession->currencyId = 3;
                // $newLession->price = $req->price;
                $newLession->description = $req->description;
                $newLession->price_gbp = !empty($req->price_gbp) ? $req->price_gbp : 0;
                $newLession->price_usd = !empty($req->price_usd) ? $req->price_usd : 0;
                $newLession->price_euro = !empty($req->price_euro) ? $req->price_euro : 0;
                $newLession->keywords = emptyCheck($req->keywords);
                $newLession->genre = !empty($req->genre) ? $req->genre : 0;
                $newLession->item_clean_url = emptyCheck($req->item_clean_url);
                $newLession->product_code = emptyCheck($req->product_code);
                $newLession->createdBy = $user->id;
                $newLession->save();
                return redirect(route('admin.product.series.lession.list', [$instrumentId, $productSeriesId]))->with('Success', 'Product Lession Added SuccessFully');
            }
        }
        return abort(404);
    }

    // LESSON - EDIT
    public function productSeriesLessionEdit(Request $req, $instrumentId, $productSeriesId, $lessionId)
    {
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $user = $req->user();
            $genre = Genre::orderBy('name')->get();
            $productLession = ProductSeriesLession::where('id', $lessionId)->where('productSeriesId', $productSeriesId)->where('instrumentId', $instrument->id)->first();
            if ($productLession) {
                return view('admin.product.lession.edit', compact('instrument', 'productLession', 'genre'));
            }
        }
        return abort(404);
    }

    // LESSON - UPDATE
    public function productSeriesLessionUpdate(Request $req, $instrumentId, $productSeriesId, $lessionId)
    {
        $req->validate([
            'instrumentId' => 'required|min:1|numeric|in:' . $instrumentId,
            'productSeriesId' => 'required|min:1|numeric|in:' . $productSeriesId,
            'productLessionId' => 'required|min:1|numeric|in:' . $lessionId,
            'title' => 'required|string|max:200',
            'difficulty' => 'required|string|in:Easy,Medium,Hard',
            // 'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'preview_video' => 'nullable|mimes:mp4, 3gp, mkv, avi, flv, wmv, webm, ogx, oga, ogv, ogg, mov, m3u8, ts',
            'video' => 'nullable',
            'price_gbp' => 'nullable|min:1|numeric',
            'price_usd' => 'nullable|min:1|numeric',
            'price_euro' => 'nullable|min:1|numeric',
            'keywords' => 'nullable|max:255',
            'genre' => 'nullable|min:1|numeric',
            'item_clean_url' => 'nullable|url',
            'product_code' => 'nullable',
        ]);
        $instrument = $this->getInstrument($instrumentId);
        if ($instrument) {
            $user = $req->user();
            $productSeries = ProductSeries::where('id', $productSeriesId)->where('instrumentId', $instrument->id)->first();
            if ($productSeries) {
                $updateLession = ProductSeriesLession::where('id', $req->productLessionId)->where('instrumentId', $instrument->id)->where('productSeriesId', $productSeries->id)->first();
                if ($updateLession) {
                    $updateLession->instrumentId = $instrument->id;
                    $updateLession->categoryId = $productSeries->categoryId;
                    $updateLession->productSeriesId = $productSeries->id;
                    $updateLession->title = $req->title;
                    $updateLession->difficulty = $req->difficulty;
                    if ($req->hasFile('image')) {
                        $image = $req->file('image');
                        $updateLession->image = imageUpload($image, 'product/lession');
                    }
                    if ($req->hasFile('preview_video')) {
                        $preview_video = $req->file('preview_video');
                        $updateLession->preview_video = imageUpload($preview_video, 'product/lession/video');
                    }
                    if ($req->hasFile('video')) {
                        $video = $req->file('video');
                        $updateLession->video = imageUpload($video, 'product/lession/video');
                    }
                    $updateLession->currencyId = 3;
                    // $updateLession->price = $req->price;
                    $updateLession->description = $req->description;
                    $updateLession->price_gbp = !empty($req->price_gbp) ? $req->price_gbp : 0;
                    $updateLession->price_usd = !empty($req->price_usd) ? $req->price_usd : 0;
                    $updateLession->price_euro = !empty($req->price_euro) ? $req->price_euro : 0;
                    $updateLession->keywords = emptyCheck($req->keywords);
                    $updateLession->genre = !empty($req->genre) ? $req->genre : 0;
                    $updateLession->item_clean_url = emptyCheck($req->item_clean_url);
                    $updateLession->product_code = emptyCheck($req->product_code);
                    $updateLession->save();
                    return redirect(route('admin.product.series.lession.list', [$instrumentId, $productSeriesId]))->with('Success', 'Product Product Series Lession Updated SuccessFully');
                }
            }
        }
        return abort(404);
    }

    // LESSON - DELETE
    public function productSeriesLessionDelete(Request $req)
    {
        $rules = [
            'instrumentId' => 'required|numeric|min:1',
            'productSeriesId' => 'required|numeric|min:1',
            'seriesLessionId' => 'required|numeric|min:1',
        ];
        $validator = validator()->make($req->all(), $rules);
        if (!$validator->fails()) {
            $lession = ProductSeriesLession::where('id', $req->seriesLessionId)->where('instrumentId', $req->instrumentId)->where('productSeriesId', $req->productSeriesId)->first();
            if ($lession) {
                $lession->delete();
                return successResponse('Product Series Lession Deleted Success');
            }
            return errorResponse('You donot have permission to delete');
        }
        return errorResponse($validator->errors()->first());
    }
}
