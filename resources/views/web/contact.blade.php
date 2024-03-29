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
                                    <li class="breadcrumb-item active" aria-current="page">Contact us</li>
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
                <div class="member-area-from-wrap row">
                    <div class="col-md-7">
                        <div class="login-reg-form-wrap">
                            <h5>Contact Us</h5>
                            <form class="form-horizontal" method="POST" action="http://localhost/mlm/public/member/login">
                                <input type="hidden" name="_token" value="chFmORkmWRPy7iuF2zkJkWqdNuyXFbDpR7o32AfG">
                                <div class="single-input-item">
                                    <input type="text" name="full_name" placeholder="Full Name" required="">
                                </div>
                                <div class="single-input-item">
                                    <input type="email" name="email" placeholder="Email" required="">
                                </div>
                                <div class="single-input-item">
                                    <input type="number" name="mobile" placeholder="Mobile" required="">
                                </div>
                               <div class="single-input-item">
                                   <textarea name="msg" id="msg" cols="30" rows="10" placeholder="Message"></textarea>
                               </div>
                                <div class="single-input-item">
                                    <button class="btn btn-sqr">Contact Us</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="login-reg-form-wrap">
                            <h5>Get In Touch Us</h5>
                            <div class="contact-info">
                                <div class="single-input-item">
                                    <i class="pe-7s-home"></i>
                                    <p class="d-inline">4710-4890 Breckinridge Guwahati, Assam</p>
                                </div>
                                <div class="single-input-item">
                                    <i class="pe-7s-phone"></i>
                                    <a href="">+91 9456781245</a>
                                </div>
                                <div class="single-input-item">
                                    <i class="pe-7s-mail"></i>
                                    <a href="">mail@demo.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login register wrapper end -->
    </main>
@endsection

@section('script') 
@endsection
