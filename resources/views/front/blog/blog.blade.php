@extends('layouts.master')
@section('title','Blog')
@section('content')
    <!-- blog listings -->
    <div class="sidebar-page-container">
        <div class="container">
            <div class="row clearfix">
                <!-- Content Side -->
                <div class="mb-5 col-lg-8 col-md-12 col-sm-12">
                    <div class="our-blogs">
                        <!-- News Block Two -->
                        <div class="news-block-two mb-5">
                            <div class="inner-box position-relative">
                                <div class="position-relative">
                                    <a href="#"><img width="100%" src="{{asset('design/img/guitar_5.png')}}" alt=""></a>
                                    <div class="post-date">
                                        <h6>19 <span class="d-block">JUL</span></h6>
                                    </div>
                                </div>

                                <div class="lower-content">
                                    <ul class="post-info">
                                        <li><span class="author-image"><img src="{{asset('design/img/team-2.jpg')}}" alt=""></span>By: Admin
                                        </li>
                                        <li>Category: <span class="theme_color">Disinfection</span></li>
                                        <li>Comments: 150</li>
                                    </ul>
                                    <h3><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</a></h3>
                                    <div class="text">Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                        mini
                                        veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex eay duis
                                        aute
                                        irure dolor in reprehenderit. Voluptate velit esse cillum dolore eu fugiat.
                                    </div>
                                    <div class="position-relative text-right">
                                        <a href="#" class="read-more theme-btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- News Block Two -->
                        <div class="news-block-two mb-5">
                            <div class="inner-box position-relative">
                                <div class="position-relative">
                                    <a href="#"><img width="100%" src="{{asset('design/img/guitar_4.png')}}" alt=""></a>
                                    <div class="post-date">
                                        <h6>19 <span class="d-block">JUL</span></h6>
                                    </div>
                                </div>
                                <div class="lower-content">
                                    <ul class="post-info">
                                        <li><span class="author-image"><img src="{{asset('design/img/team-2.jpg')}}" alt=""></span>By: Admin
                                        </li>
                                        <li>Category: <span class="theme_color">Disinfection</span></li>
                                        <li>Comments: 150</li>
                                    </ul>
                                    <h3><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</a></h3>
                                    <div class="text">Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                        mini
                                        veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex eay duis
                                        aute
                                        irure dolor in reprehenderit. Voluptate velit esse cillum dolore eu fugiat.
                                    </div>
                                    <div class="position-relative text-right">
                                        <a href="#" class="read-more theme-btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- News Block Two -->
                        <div class="news-block-two mb-5">
                            <div class="inner-box position-relative">
                                <div class="position-relative">
                                    <a href="#"><img width="100%" src="{{asset('design/img/guitar_3.png')}}" alt=""></a>
                                    <div class="post-date">
                                        <h6>19 <span class="d-block">JUL</span></h6>
                                    </div>
                                </div>
                                <div class="lower-content">
                                    <ul class="post-info">
                                        <li><span class="author-image"><img src="{{asset('design/img/team-2.jpg')}}" alt=""></span>By: Admin
                                        </li>
                                        <li>Category: <span class="theme_color">Disinfection</span></li>
                                        <li>Comments: 150</li>
                                    </ul>
                                    <h3><a href="#">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</a></h3>
                                    <div class="text">Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                        mini
                                        veniam quis nostrud exercitation ullamco laboris nisi ut aliquip ex eay duis
                                        aute
                                        irure dolor in reprehenderit. Voluptate velit esse cillum dolore eu fugiat.
                                    </div>
                                    <div class="position-relative text-right">
                                        <a href="#" class="read-more theme-btn">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Paginations -->
                        <nav aria-label="Page navigation example w-100 w-sm-75 w-md-50 m-auto">
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

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

                                <form action="#">
                                    <div class="form-group position-relative">
                                        <input type="search" name="search-field" value="" placeholder="Type keyword"
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
                                    <li><a href="#">Covid-19 (Coronavirus)</a></li>
                                    <li><a href="#">Staphylococcus</a></li>
                                    <li><a href="#">Influenza (Flu)</a></li>
                                    <li><a href="#">EV-D68 &amp; Paralysis</a></li>
                                    <li><a href="#">Mold &amp; MRSA</a></li>
                                    <li><a href="#">All Types Bacteria</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Popular Posts -->
                        <div class="sidebar-widget popular-posts">
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
                        </div>

                        <!-- Instagram Widget -->
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
                        </div>

                        <!-- Popular Posts -->
                        <div class="sidebar-widget popular-tags">
                            <div class="widget-content">
                                <div class="sidebar-title">
                                    <h5>Popular Tags</h5>
                                </div>
                                <a href="#">Disinfection</a>
                                <a href="#">Business</a>
                                <a href="#">COVID 19</a>
                                <a href="#">Sanatize</a>
                                <a href="#">Virus</a>
                                <a href="#">Bacteria</a>
                                <a href="#">Mold</a>
                                <a href="#">Odour Control</a>
                                <a href="#">Germs</a>
                            </div>
                        </div>

                    </aside>
                </div>

            </div>
        </div>
    </div>
@endsection
