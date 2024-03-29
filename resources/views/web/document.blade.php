@extends('web.templet.master')

@section('seo')
    <link href="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/css/lightgallery.css" rel="stylesheet">
    <link href="{{asset('web/css/lightgallery.css')}}" rel="stylesheet">
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
                                    <li class="breadcrumb-item active" aria-current="page">Document</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- login register wrapper start -->
        <div class="login-register-wrapper section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">Document</h2>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="member-area-from-wrap">
                    <div class="demo-gallery">
                        <ul id="lightgallery" class="list-unstyled row">
                            @if (isset($legals) && !empty($legals))
                                @foreach ($legals as $gl)
                                    <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="img/1-375.jpg 375, img/1-480.jpg 480, img/1.jpg 800" data-src="{{asset('legal/documents/'.$gl->documents)}}" data-sub-html="<h4>Fading Light</h4><p>Classic view from Rigwood Jetty on Coniston Water an old archive shot similar to an old post but a little later on.</p>" data-pinterest-text="Pin it1" data-tweet-text="share on twitter 1">
                                        <div class="img-card">
                                            <a href="">
                                                <img class="img-responsive" src="{{asset('legal/'.$gl->photo)}}" alt="Thumb-1">
                                            </a>
                                            <h3>{{ $gl->name }}</h3>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="pull-right">
                            {{ $legals->links() }}    
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <!-- login register wrapper end -->
    </main>
@endsection

@section('script') 
        <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
        <script src="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/js/lightgallery.js"></script>
        <script src="https://cdn.rawgit.com/sachinchoolur/lg-pager.js/master/dist/lg-pager.js"></script>
        <script src="https://cdn.rawgit.com/sachinchoolur/lg-fullscreen.js/master/dist/lg-fullscreen.js"></script>
        <script>
            lightGallery(document.getElementById('lightgallery'));
        </script>
        <style>.img-card a {margin-bottom: 10px}.img-card h3 {font-size: 20px;text-align: center;font-weight: 700}</style>
@endsection
