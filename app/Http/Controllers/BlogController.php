<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $req)
    {
        return view('front.blog.blog');
    }

    public function blogDetails(Request $req,$blogId)
    {
        return view('front.blog.blogDetails');
    }
}
