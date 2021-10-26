@extends('web.templet.master')

@section('seo')

@endsection

@section('content')
    <main>
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Product List</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end sssdreamlife -->

        <!-- page main wrapper start -->
        <div class="shop-main-wrapper section-padding">
            <div class="container">
                <div class="row">
                    <!-- sidebar area start -->
                    <div class="col-lg-2 order-1">
                        <aside class="sidebar-wrapper">
                            
                        </aside>
                    </div>
                    <!-- sidebar area end -->

                    <!-- shop main wrapper start -->
                    <div class="col-lg-10 order-2">
                        <div class="shop-product-wrapper">
                            <!-- shop product top wrap start -->
                            <div class="shop-top-bar">
                                <div class="row align-items-center">
                                </div>
                            </div>
                            <!-- shop product top wrap start -->

                            <!-- product item list wrapper start -->
                            <div class="shop-product-wrap grid-view row mbn-30">
                                {{-- @if(isset($products) && !empty($products))
                                    @foreach ($products as $product) --}}
                                        <!-- product single item start -->
                                        {{-- <div class="col-md-3 col-sm-6"> --}}
                                            <!-- product grid start -->
                                            {{-- <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="{{route('web.product.product-detail', ['id' => encrypt($product->id)])}}">
                                                        <img class="pri-img" src="{{asset('web/img/product/'.$product->main_image)}}" alt="product">
                                                    </a>
                                                    <div class="cart-hover">
                                                        <button class="btn btn-cart">add to cart</button>
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="{{route('web.product.product-detail', ['id' => encrypt($product->id)])}}">{{ $product->name }}</a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <span class="price-regular">₹{{ number_format($product->mrp, 2) }}</span>
                                                        <span class="price-old"><del>₹{{ number_format($product->price, 2) }}</del></span>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <!-- product grid end -->
                                        {{-- </div> --}}
                                        <!-- product single item start -->

                                        <!-- product single item start -->
                                        <div class="col-md-3 col-sm-6">
                                            <!-- product grid start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="">
                                                        <img class="pri-img" src="{{asset('web/img/product/1.jpeg')}}" alt="product">
                                                    </a>
                                                    <div class="cart-hover">
                                                        <a href="#" data-toggle="modal" data-target-id="" data-target="#quick_view"><span data-toggle="tooltip" data-placement="left" title="Quick View"><i class="pe-7s-search"></i></span></a>
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="">Product Name Here</a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <span class="price-old"><del>₹1499</del></span>
                                                        <span class="price-regular">₹1299</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product grid end -->
                                        </div>
                                        <!-- product single item start -->

                                        <!-- product single item start -->
                                        <div class="col-md-3 col-sm-6">
                                            <!-- product grid start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="">
                                                        <img class="pri-img" src="{{asset('web/img/product/1.jpeg')}}" alt="product">
                                                    </a>
                                                    <div class="cart-hover">
                                                        <a href="#" data-toggle="modal" data-target-id="" data-target="#quick_view"><span data-toggle="tooltip" data-placement="left" title="Quick View"><i class="pe-7s-search"></i></span></a>
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="">Product Name Here</a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <span class="price-old"><del>₹1499</del></span>
                                                        <span class="price-regular">₹1299</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product grid end -->
                                        </div>
                                        <!-- product single item start -->

                                        <!-- product single item start -->
                                        <div class="col-md-3 col-sm-6">
                                            <!-- product grid start -->
                                            <div class="product-item">
                                                <figure class="product-thumb">
                                                    <a href="">
                                                        <img class="pri-img" src="{{asset('web/img/product/1.jpeg')}}" alt="product">
                                                    </a>
                                                    <div class="cart-hover">
                                                        <a href="#" data-toggle="modal" data-target-id="" data-target="#quick_view"><span data-toggle="tooltip" data-placement="left" title="Quick View"><i class="pe-7s-search"></i></span></a>
                                                    </div>
                                                </figure>
                                                <div class="product-caption text-center">
                                                    <h6 class="product-name">
                                                        <a href="">Product Name Here</a>
                                                    </h6>
                                                    <div class="price-box">
                                                        <span class="price-old"><del>₹1499</del></span>
                                                        <span class="price-regular">₹1299</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product grid end -->
                                        </div>
                                        <!-- product single item start -->
                                    {{-- @endforeach
                                @endif --}}

                            </div>
                            <!-- product item list wrapper end -->

                            <!-- start pagination area -->
                            <div class="paginatoin-area text-center">
                                <ul class="pagination-box">
                                   
                                  {{-- {{ $products->links() }} --}}
                                   
                                </ul>
                            </div>
                            <!-- end pagination area -->
                        </div>
                    </div>
                    <!-- shop main wrapper end -->
                </div>
            </div>
        </div>
        <!-- page main wrapper end -->
    </main>
@endsection

@section('script') 
@endsection
