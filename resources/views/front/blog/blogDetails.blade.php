@extends('layouts.master')
@section('title','Blog Details')
@section('content')

<!-- blog listings -->
<div class="sidebar-page-container">
    <div class="container">
        <div class="row clearfix">
            <!-- Content Side -->
            <div class="mb-5 col-lg-8 col-md-12 col-sm-12">
                <div class="blog-detail">
                    <div class="inner-box">
                        <div class="image">
                            <img src="{{asset($data->image)}}" alt="">
                            <div class="post-date">
                                <h6>{{date('d',strtotime($data->created_at))}} <span class="d-block">{{date('M',strtotime($data->created_at))}}</span></h6>
                            </div>
                        </div>
                        <div class="lower-content">
                            <ul class="post-info">
                                @if($author = $data->author)
                                    <li><span class="author-image"><img src="{{asset($author->image)}}" alt=""></span>By: {{ucwords($author->name)}}</li>
                                @endif
                                @if($category = $data->blog_category)
                                    <li>Category: <span class="theme_color">{{ucwords($category->title)}}</span></li>
                                @endif
                                <li>Comments: <span id="blogComment">{{count($data->comments)}}</span></li>
                            </ul>
                            <h3>{{ucwords($data->title)}}</h3>

                            <div class="text">{!! $data->description !!}</div>

                            <!-- Other Options -->
                            <div class="post-share-options d-flex justify-content-between align-items-center">
                                @if(count($data->selectedTags) > 0)
                                    <div class="pull-left">
                                        <div class="post-title">Post Tags</div>
                                        <ul class="tags">
                                            @foreach($data->selectedTags as $selectedTag)
                                                <li><a href="javascript:void(0)">{{$selectedTag->title}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="pull-right">
                                    <div class="post-title">Share This</div>
                                    <ul class="social-icon">
                                        <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                        <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                                        <li><a href="#"><span class="fab fa-google-plus"></span></a></li>
                                        <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(count($data->relatedPosts) > 0)
                    <!-- Related Projects -->
                    <div class="related-projects">
                        <h3>Related Posts</h3>
                        <div class="row clearfix">
                            <!-- News Block -->
                            @foreach($data->relatedPosts as $index => $relatedpost)
                                <div class="news-block mb-5 col-lg-6 col-md-6 col-sm-12">
                                    <div class="inner-box wow fadeInRight animated" data-wow-delay="0ms"
                                        data-wow-duration="1500ms"
                                        style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInRight;">
                                        <div class="image">
                                            <a href="{{route('blogs.details',[$relatedpost->id,'title' => $relatedpost->title])}}"><img src="{{asset($relatedpost->image)}}"></a>
                                            <div class="post-date">{{date('M d, Y',strtotime($relatedpost->created_at))}}</div>
                                        </div>
                                        <div class="lower-content">
                                            <ul class="post-info">
                                                @if($authorpost = $relatedpost->author)
                                                    <li>By: {{ucwords($authorpost->name)}}</li>
                                                @endif
                                                @if($categoryPost = $relatedpost->blog_category)
                                                    <li>Category: <span>{{ucwords($categoryPost->title)}}</span></li>
                                                @endif
                                            </ul>
                                            <h4><a href="{{route('blogs.details',[$relatedpost->id,'title' => $relatedpost->title])}}">{{ucwords($relatedpost->title)}}</a>
                                            </h4>
                                            <div class="text">{!! words($relatedpost->description,100) !!}
                                            </div>
                                            <a href="{{route('blogs.details',[$relatedpost->id,'title' => $relatedpost->title])}}" class="read-more theme-btn">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="comments-area py-5">
                    <div class="group-title">
                        <h5>Comments</h5>
                    </div>
                    <div id="commentWillAppearHere">
                        @forelse($data->comments as $commentIndex => $commentValue)
                            @if($commentedUser = $commentValue->user_data)
                                <div class="comment-box">
                                    <div class="comment">
                                        <div class="author-thumb d-flex justify-content-center align-items-center"><img src="{{asset($commentedUser->image)}}" alt=""></div>
                                        <div class="comment-info clearfix"><strong>{{ucwords($commentedUser->name)}}</strong>
                                            <div class="comment-time">{{date('d M, Y',strtotime($commentValue->created_at))}} at {{date('h:i A',strtotime($commentValue->created_at))}}</div>
                                        </div>
                                        <div class="text">{{$commentValue->comment}}</div>
                                        <!-- <a class="theme-btn reply-btn" href="#">reply</a> -->
                                    </div>
                                </div>
                            @endif
                        @empty
                            <span id="notFoundCommentHere">{{('no Comment found')}}</span>
                        @endforelse
                    </div>
                </div>
                
                @auth
                <!-- Comment Form -->
                    <div class="comment-form">
                        <div class="group-title">
                            <h5>Post Reply</h5>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <textarea class="" name="message" id="blogCommentInbox" placeholder="Your Message" spellcheck="false"></textarea>
                            </div>
                            <span class="text-danger commentError"></span>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <button class="btn-style-one mt-3 blogCommentSubmit" type="submit" name="submit-form">send comment</button>
                            </div>
                        </div>
                    </div>
                @endauth
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
                        </div>
                    </div>

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

@section('script')
    <script type="text/javascript">
        @auth
            $(document).on('click','.blogCommentSubmit',function(){
                $('.commentError').text('');
                var comment = $('#blogCommentInbox').val();
                if(comment == '' || comment == null || comment == undefined){
                    $('.commentError').text('Please type your message');
                }else{
                    $.ajax({
                        url : "{{route('user.blog.comment.post')}}",
                        type : 'POST',
                        dataType : 'JSON',
                        data : {
                            userId : '{{$user->id}}',
                            blogId : '{{$data->id}}',
                            comment : comment,
                            _token : '{{csrf_token()}}',
                        },
                        success:function(response){
                            if(response.error == false){
                                var toAppend = '<div class="comment-box"><div class="comment"><div class="author-thumb d-flex justify-content-center align-items-center"><img src="{{asset($user->image)}}"></div><div class="comment-info clearfix"><strong>{{ucwords($user->name)}}</strong><div class="comment-time">'+response.data.now_time+'</div></div><div class="text">'+response.data.comment+'</div></div></div>';
                                $('#commentWillAppearHere').prepend(toAppend);
                                $('#notFoundCommentHere').remove();
                                $('#blogCommentInbox').val('');
                            }else{
                                alert('Something went wrong please try after sometime');
                            }
                        }
                    });
                }
            });
        @endauth
    </script>
@stop

@endsection