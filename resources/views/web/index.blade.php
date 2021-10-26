@extends('web.templet.master')

@section('seo')

@endsection

@section('content')
    
    <main style="background:url('web/img/patt.jpg')">
        <!-- hero slider area start -->
        @if(isset($sliders) && !empty($sliders))
        <section class="slider-area">
            <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
                @foreach ($sliders as $slider)
                <!-- single slider item start -->
                <div class="hero-single-slide hero-overlay">
                    <div class="hero-slider-item bg-img" data-bg="{{asset('admin/photo/'.$slider->slider_image)}}" width="1350">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hero-slider-content slide-1">
                                        <h2 class="slide-title">{{$slider->banner_title}}</h2>
                                        <h4 class="slide-desc">{{$slider->banner_subtitle}}</h4> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single slider item start -->
                @endforeach
            </div>
        </section>
        @endif
        <!-- hero slider area end -->

        @if(isset($products) && !empty($products))
        <!-- product area start -->
        <section class="product-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">our products</h2>
                            <p class="sub-title">Best Products ever</p>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-container">

                            <!-- product tab content start -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab1">
                                    <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                                        @foreach ($products as $product)
                                        <!-- product item start -->
                                        <div class="product-item">
                                            <figure class="product-thumb">
                                                <a href="">
                                                    <img class="pri-img" src="{{asset('admin/photo/'.$product->main_image)}}" alt="product">
                                                    <img class="sec-img" src="{{asset('admin/photo/'.$product->main_image)}}" alt="product">
                                                </a>
                                                <div class="product-badge">
                                                    <div class="product-label new">
                                                        <span>new</span>
                                                    </div>
                                                </div>
                                                <div class="button-group">
                                                    <a href="#" data-toggle="modal" data-target-id="" data-target="#quick_view"><span data-toggle="tooltip" data-placement="left" title="Quick View"><i class="pe-7s-search"></i></span></a>
                                                </div>
                                            </figure>
                                            <div class="product-caption text-center">
                                                <h6 class="product-name">
                                                    <a href="">{{ $product->name }}</a>
                                                </h6>
                                                <div class="price-box">
                                                    <span class="price-old"><del>₹{{ number_format($product->mrp, 2) }}</del></span>
                                                    <span class="price-regular">₹{{ number_format($product->price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product item end -->
                                        @endforeach
                                        <!-- product item end --> 
                                    </div>
                                </div>
                            </div>
                            <!-- product tab content end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product area end -->
        @endif
    
        <!-- about us area start -->
        <section class="about-us section-padding">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="about-thumb">
                            <img src="{{asset('web/img/immunity.png')}}" alt="about thumb">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="about-content">
                            <h2 class="about-title">About Us</h2>
                            <h5 class="about-sub-title">
                                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here'.
                            </h5>
                            <p>, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about us area end -->
    </main>
@endsection

@section('script') 

@endsection
