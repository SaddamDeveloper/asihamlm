<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Frotend;
use App\Rewards;
use Carbon\Carbon;
use App\Tree;
use App\Model\ShoppingCategory;
use App\Models\Gallery;
use App\Models\Legal;
use App\Models\ShoppingProduct;
use App\Models\ShoppingSlider;
use App\Models\VideoGallery;
use App\Models\VideoPlan;
use Illuminate\Contracts\Encryption\DecryptException;

class WebsiteController extends Controller
{
    public function index(){
        $slider = ShoppingSlider::where('status', 1)->orderBy('created_at', 'DESC')->get();
        $product = ShoppingProduct::where('section', 1)->where('status', 1)->orderBy('created_at', 'DESC')->get();
        $product1 = ShoppingProduct::where('section', 2)->where('status', 1)->orderBy('created_at', 'ASC')->get();
        return view('web.index');
    }
    public function about(){
        return view('web.about');
    }
    public function plan(){
        return view('web.plan');
    }

    public function product(){
        // $product = ShoppingProduct::where('section', 2)->orderBy('created_at', 'DESC')->paginate(4);
        return view('web.product');
    }
    
    public function contact(){
        return view('web.contact');
    }
   

    public function productList(){
        // $categories = ShoppingCategory::orderBy('created_at', 'DESC')->where('status', 1)->take(5)->get();
        // $products = ShoppingProduct::where('section', 1)->where('status', 1)->orderBy('created_at', 'DESC')->paginate(8);
        $categories = null;
        $products = null;
        return view('web.product.product-list', compact('products', 'categories'));
    }
    public function productDetail($id){
        try{
            $id = decrypt($id);
        }catch(DecryptException $e) {
            abort(404);
        }
        $product_detail = ShoppingProduct::find($id);
        $related_product = ShoppingProduct::orderBy('created_at', 'DESC')->where('status', 1)->where('section', 1)->paginate(10);

        return view('web.product.product-detail', compact('product_detail', 'related_product'));
    }

    public function productData(Request $request){
        if($request->ajax()){
            $id = $request->get('id');
            if(!empty($id)) {
                $product_data = ShoppingProduct::find($id);
                $output = '<div class="row">
                <div class="col-lg-5">
                    <div class="product-large-slider">
                        <div class="pro-large-img img-zoom">
                            <img src="'.asset('web/img/product/'.$product_data->main_image).'" alt="product-details" />
                        </div>
                    </div>
                   
                </div>
                <div class="col-lg-7">
                    <div class="product-details-des">
                        <div class="manufacturer-name">
                            <a href="">SSSDREAMLIFE</a>
                        </div>
                        <h3 class="product-name">'.$product_data->name.'</h3>
                        <div class="price-box">
                            <span class="price-regular">₹'.number_format($product_data->price, 2).'</span>
                            <span class="price-old"><del>₹'.number_format($product_data->mrp, 2).'</del></span>
                        </div>
                        <h5 class="offer-text"><strong>Hurry up</strong>! offer ends in:</h5>
                        <div class="product-countdown" data-countdown="2022/02/20"></div>
                        <p class="pro-desc">'.$product_data->long_desc.'</p>
                        <div class="like-icon">
                            <a class="facebook" href="#"><i class="fa fa-facebook"></i>like</a>
                            <a class="twitter" href="#"><i class="fa fa-twitter"></i>tweet</a>
                            <a class="pinterest" href="#"><i class="fa fa-pinterest"></i>save</a>
                            <a class="google" href="#"><i class="fa fa-google-plus"></i>share</a>
                        </div>
                    </div>
                </div>
            </div>';
            return $output;
            }else{
                return 1;
            }
        }
    }
    
    public function image(){
        $gallery = Gallery::whereStatus(1)->orderBy('created_at', 'DESC')->paginate(8);
        return view('web.gallery.image', compact('gallery'));
    }

    public function categoryFilter($id){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $products = ShoppingProduct::orderBy('created_at', 'DESC')->where('status', 1)->where('category_id', $id)->paginate(10);
        return view('web.product.product-list', compact('products'));
    }

    public function legalDocs(){
        $legal = Legal::orderBy('created_at', 'DESC')->paginate(8);
        return view('web.legal', compact('legal'));
    }
    
    public function video() {
        $video_gallery = VideoGallery::whereStatus(1)->orderBy('created_at', 'DESC')->paginate(8);
        return view('web.gallery.video', compact('video_gallery'));
    }

    public function document() {
        $legals = Legal::whereStatus(1)->orderBy('created_at', 'DESC')->paginate(8);
        return view('web.document', compact('legals'));
    }
}
