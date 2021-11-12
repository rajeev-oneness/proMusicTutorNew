<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog,App\Models\BlogCategory,App\Models\BlogTag;

class BlogController extends Controller
{
    public function index(Request $req)
    {
        $data = (object)[];
        $data->blogs = Blog::select('*');
        if(!empty($req->search)){
            $data->blogs = $data->blogs->where(function($query) use ($req){
                $query->where('title', 'like', '%' . $req->search . '%')
                    ->orWhere('description','like', '%' . $req->search . '%');
            });
        }
        if(!empty($req->categoryId) && $req->categoryId > 0){
            $data->blogs = $data->blogs->where('blogCategoryId',$req->categoryId);
        }
        if(!empty($req->tagId) && $req->tagId > 0){
            $data->blogs = $data->blogs->whereRaw('FIND_IN_SET("'.$req->tagId.'",tags)');
        }
        $data->blogs = $data->blogs->latest()->paginate(6);
        foreach ($data->blogs as $key => $value) {
            $value->selectedTags = [];
            if($value->tags != ''){
                $value->selectedTags = BlogTag::whereIn('id',explode(',',$value->tags))->get();
            }
        }
        $data->blogTags = BlogTag::select('*')->latest()->get();
        $data->blogCategory = BlogCategory::select('*')->latest()->get();
        return view('front.blog.blog',compact('data'));
    }

    public function blogDetails(Request $req,$blogId)
    {
        $data = Blog::findOrfail($blogId);
        $data->selectedTags = [];
        if($data->tags != ''){
            $data->selectedTags = BlogTag::whereIn('id',explode(',',$data->tags))->get();
        }
        $data->relatedPosts = Blog::where('id','!=',$data->id)->where(function($query) use ($data){
            $query->where('blogCategoryId', $data->blogCategoryId);
            if($data->tags != '' && $realTag = explode(',', $data->tags)){
                foreach ($realTag as $key => $tag) {
                   $query->orWhereRaw('FIND_IN_SET("'.$tag.'",tags)');
                }
            }
        })->latest()->limit(2)->get();
        $data->blogTags = BlogTag::select('*')->latest()->get();
        $data->blogCategory = BlogCategory::select('*')->latest()->get();
        return view('front.blog.blogDetails',compact('data'));
    }
}
