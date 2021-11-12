@extends('layouts.master')
@section('title','Blog')
@section('content')
    <div class="sidebar-page-container">
        <div class="container">
            <div class="row clearfix">
                <!-- Content Side -->
                <div class="mb-5 col-lg-8 col-md-12 col-sm-12">
                    <div class="our-blogs">
                        @forelse($data->blogs as $blogIndex => $blogValue)
                            <div class="news-block-two mb-5">
                                <div class="inner-box position-relative">
                                    <div class="position-relative">
                                        <a href="{{route('blogs.details',[$blogValue->id,'title' => $blogValue->title])}}"><img width="100%" src="{{asset($blogValue->image)}}" alt=""></a>
                                        <div class="post-date">
                                            <h6>{{date('d',strtotime($blogValue->created_at))}} <span class="d-block">{{date('M',strtotime($blogValue->created_at))}}</span></h6>
                                        </div>
                                    </div>
                                    <div class="lower-content">
                                        <ul class="post-info">
                                            @if($author = $blogValue->author)
                                                <li><span class="author-image"><img src="{{asset($author->image)}}" alt=""></span>By: {{ucwords($author->name)}}</li>
                                            @endif
                                            @if($category = $blogValue->blog_category)
                                                <li>Category: <span class="theme_color">{{ucwords($category->title)}}</span></li>
                                            @endif
                                            <li>Comments: <span id="blogComment">{{count($blogValue->comments)}}</span></li>
                                            <li>Tags: @forelse($blogValue->selectedTags as $selectedT){{$selectedT->title}}, @empty {{('N/A')}} @endforelse</li>                                            
                                        </ul>
                                        <h3><a href="{{route('blogs.details',[$blogValue->id,'title' => $blogValue->title])}}">{{words(ucwords($blogValue->title),100)}}</a></h3>
                                        <div class="text">{!! words($blogValue->description, 400) !!}</div>
                                        <div class="position-relative text-right">
                                            <a href="{{route('blogs.details',[$blogValue->id,'title' => $blogValue->title])}}" class="read-more theme-btn">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            {{'No Data Found'}}
                        @endforelse
                        <div class="float-right">{{$data->blogs->appends(request()->query())->links()}}</div>
                    </div>
                </div>

                <!-- Sidebar Side -->
                <div class="mb-5 col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar">
                        <!-- Search Widget -->
                        <div class="sidebar-widget search-widget">
                            <div class="widget-content">
                                <div class="sidebar-title">
                                    <h5>Search Blog</h5>
                                </div>
                                <form action="{{route('welcome.blogs')}}">
                                    <div class="form-group position-relative">
                                        <input type="search" name="search" value="{{(request()->search ?? '')}}" placeholder="Type keyword"
                                            required="">
                                        <button type="submit"><span class="icon fa fa-search"></span></button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <!-- category -->
                        <div class="sidebar-widget category-widget-two">
                            <div class="widget-content">
                                <div class="sidebar-title">
                                    <h5>Categories</h5>
                                </div>

                                <ul class="cat-list-two">
                                    @foreach($data->blogCategory as $catIndex => $catValue)
                                        <li><a href="{{route('welcome.blogs',['categoryId'=>$catValue->id,'categoryName'=>$catValue->title])}}">{{words(ucwords($catValue->title),30)}} ({{(count($catValue->blogs_data))}})</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Popular Posts -->
                        <!-- <div class="sidebar-widget popular-posts">
                            <div class="widget-content">
                                <div class="sidebar-title">
                                    <h5>Recent news</h5>
                                </div>
                                <div class="post d-flex align-items-center justify-content-around">
                                    <div class="post-thumb w-50">
                                        <img src="img/guitar_3.png" alt="">
                                    </div>
                                    <div class="text">
                                        <a href="#">You should concerned about covid-19</a>
                                        <div class="post-info">July 25, 2021</div>
                                    </div>
                                </div>
                                <div class="post d-flex align-items-center justify-content-around">
                                    <div class="post-thumb w-50">
                                        <img src="{{asset('design/img/guitar_3.png')}}" alt="">
                                    </div>
                                    <div class="text">
                                        <a href="#">Bacterias Removal: How to do safely</a>
                                        <div class="post-info">July 25, 2021</div>
                                    </div>
                                </div>
                                <div class="post d-flex align-items-center justify-content-around"> 
                                    <div class="post-thumb w-50">
                                        <img src="{{asset('design/img/guitar_3.png')}}" alt="">
                                    </div>
                                    <div class="text">
                                        <a href="#">Questions to ask for sanitizer
                                            <div class="post-info">July 25, 2021</div>
                                            company</a></div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Instagram Widget 
                        <div class="sidebar-widget instagram-widget">
                            <div class="widget-content">
                                <div class="sidebar-title">
                                    <h5>Projects Instagram</h5>
                                </div>
                                <div class="clearfix">
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                    <figure class="post-thumb"><img src="img/team-1.jpg" alt=""><a href="#"
                                            class="overlay-box"><span class="icon fa fa-link"></span></a></figure>
                                </div>
                            </div>
                        </div> -->

                        <!-- Popular Posts -->
                        <div class="sidebar-widget popular-tags">
                            <div class="widget-content">
                                <div class="sidebar-title">
                                    <h5>Popular Tags</h5>
                                </div>
                                @foreach($data->blogTags as $tagIndex => $tagValue)
                                    <a href="{{route('welcome.blogs',['tagId'=>$tagValue->id,'tagName'=>$tagValue->title])}}">{{words(ucwords($tagValue->title),30)}} ({{count($tagValue->blogs_data($tagValue->id))}})</a>
                                @endforeach
                            </div>
                        </div>

                    </aside>
                </div>

            </div>
        </div>
    </div>
@endsection
