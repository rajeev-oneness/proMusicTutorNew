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
                                <img src="{{asset('design/img/guitar_4.png')}}" alt="">
                                <div class="post-date">
                                    <h6>19 <span class="d-block">JUL</span></h6>
                                </div>
                            </div>
                            <div class="lower-content">
                                <ul class="post-info">
                                    <li><span class="author-image"><img src="{{asset('design/img/team-1.jpg')}}"
                                                alt=""></span>By: Admin</li>
                                    <li>Category: <span class="theme_color">Disinfection</span></li>
                                    <li>Comments: 150</li>
                                </ul>
                                <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit.</h3>
                                <div class="text">
                                    <p>Tempor incididunt ut labore et dolore magna aliqua. Ut enim ad mini veniam quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip ex eay duis aute irure
                                        dolor in reprehenderit. Voluptate velit esse cillum dolore eu fugiat. Lorem
                                        ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.</p>
                                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                        aliquip ex ea commodo consequat. Duis aute irure dolorn reprehenderit in
                                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                                    <div class="images-gallery">
                                        <div class="row clearfix">
                                            <div class="column col-lg-6 col-md-6 col-sm-12">
                                                <img src="{{asset('design/img/guitar_5.png')}}" alt="">
                                            </div>
                                            <div class="column col-lg-6 col-md-6 col-sm-12">
                                                <img src="{{asset('design/img/guitar_6.png')}}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <h4>We Make Your Area Clinically Safe &amp; Clean</h4>
                                    <div class="bold-text">Anti-Viral EPA Approved Surface Disinfectant Spraying
                                        Treatments For number of Viruses &amp; Bacterias Including...</div>
                                    <div class="row clearfix">
                                        <div class="column col-lg-6 col-md-6 col-sm-12">
                                            <ul class="list-style-one">
                                                <li>Covid-19 (Coronavirus)</li>
                                                <li>Staphylococcus</li>
                                                <li>Influenza (Flu)</li>
                                                <li>Noro Virus</li>
                                            </ul>
                                        </div>
                                        <div class="column col-lg-6 col-md-6 col-sm-12">
                                            <ul class="list-style-one">
                                                <li>EV-D68 &amp; Paralysis</li>
                                                <li>Mold &amp; MRSA</li>
                                                <li>All Types Bacteria</li>
                                                <li>Odour Control</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <p>Reprehenderit boluptate velit esse cillum dolore eu fugiat. Lorem ipsum dolor sit
                                        amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                                        et dolore magna aliqua.</p>
                                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                                        aliquip ex ea commodo consequat. Duis aute irure dolorn reprehenderit in
                                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                                </div>
                                <!-- Other Options -->
                                <div class="post-share-options d-flex justify-content-between align-items-center">
                                    <div class="pull-left">
                                        <div class="post-title">Post Tags</div>
                                        <ul class="tags">
                                            <li><a href="#">Sanatize</a></li>
                                            <li><a href="#">virus</a></li>
                                            <li><a href="#">odour</a></li>
                                        </ul>
                                    </div>
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

                    <!-- Related Projects -->
                    <div class="related-projects">
                        <h3>Related Posts</h3>
                        <div class="row clearfix">

                            <!-- News Block -->
                            <div class="news-block mb-5 col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box wow fadeInRight animated" data-wow-delay="0ms"
                                    data-wow-duration="1500ms"
                                    style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInRight;">
                                    <div class="image">
                                        <a href="#"><img src="{{asset('design/img/guitar_6.png')}}" alt=""></a>
                                        <div class="post-date">June 26, 2021</div>
                                    </div>
                                    <div class="lower-content">
                                        <ul class="post-info">
                                            <li>By: Admin</li>
                                            <li>Category: <span>Disinfection</span></li>
                                        </ul>
                                        <h4><a href="#">Important Questions to Ask Sanitizer Company</a>
                                        </h4>
                                        <div class="text">Iste natus error voluptatem accusan dolremque laudantis totam.
                                        </div>
                                        <a href="#" class="read-more theme-btn">Read More</a>
                                    </div>
                                </div>
                            </div>

                            <!-- News Block -->
                            <div class="news-block mb-5 col-lg-6 col-md-6 col-sm-12">
                                <div class="inner-box wow fadeInRight animated" data-wow-delay="0ms"
                                    data-wow-duration="1500ms"
                                    style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInRight;">
                                    <div class="image">
                                        <a href="#"><img src="{{asset('design/img/guitar_6.png')}}" alt=""></a>
                                        <div class="post-date">June 26, 2021</div>
                                    </div>
                                    <div class="lower-content">
                                        <ul class="post-info">
                                            <li>By: Admin</li>
                                            <li>Category: <span>Disinfection</span></li>
                                        </ul>
                                        <h4><a href="#">Important Questions to Ask Sanitizer Company</a>
                                        </h4>
                                        <div class="text">Iste natus error voluptatem accusan dolremque laudantis totam.
                                        </div>
                                        <a href="#" class="read-more theme-btn">Read More</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="comments-area py-5">
                        <div class="group-title">
                            <h5>Comments</h5>
                        </div>

                        <div class="comment-box">
                            <div class="comment">
                                <div class="author-thumb d-flex justify-content-center align-items-center"><img src="{{asset('design/img/team-1.jpg')}}" alt=""></div>
                                <div class="comment-info clearfix"><strong>Smith Hazel</strong>
                                    <div class="comment-time">10 August 2021 at 7:00 PM</div>
                                </div>
                                <div class="text">Tempor incididunt ut labore et dolore magna aliqua. Ut enim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip exa duis.</div>
                                <a class="theme-btn reply-btn" href="#">reply</a>
                            </div>
                        </div>

                        <div class="comment-box">
                            <div class="comment">
                                <div class="author-thumb d-flex justify-content-center align-items-center"><img src="{{asset('design/img/team-1.jpg')}}" alt=""></div>
                                <div class="comment-info clearfix"><strong>Scralett Luna</strong>
                                    <div class="comment-time">10 August 2021 at 7:00 PM</div>
                                </div>
                                <div class="text">Tempor incididunt ut labore et dolore magna aliqua. Ut enim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip exa duis.</div>
                                <a class="theme-btn reply-btn" href="#">Reply</a>
                            </div>
                        </div>

                    </div>

                    <!-- Comment Form -->
                    <div class="comment-form">

                        <div class="group-title">
                            <h5>Post Reply</h5>
                        </div>

                        <!--Comment Form-->
                        <form method="post"">
                            <div class="row clearfix">

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <textarea class="" name="message" placeholder="Your Message" spellcheck="false"></textarea>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="text" name="username" placeholder="Your Name" required>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input type="email" name="email" placeholder="Email" required>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <button class=" btn-style-one mt-3" type="submit" name="submit-form">send comment</button>
                                </div>

                            </div>
                        </form>

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