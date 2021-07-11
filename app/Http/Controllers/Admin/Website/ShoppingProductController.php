<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShoppingCategory;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Models\ShoppingProduct;
use App\Models\ShoppingSlider;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ShoppingProductController extends Controller
{
    public function shoppingSlider()
    {
        return view('admin.frontend.slider');
    }

    public function addShoppingSlider()
    {
        return view('admin.frontend.add_slider');
    }
    public function ShoppingSliderList(){
        return datatables()->of(ShoppingSlider::get())
        ->addIndexColumn()
        ->addColumn('slider_image', function($row){
            if($row->slider_image){
                $slider_image = '<img src="'.asset("admin/photo/".$row->slider_image).'" width="200"/>';
            }
            return $slider_image;
        })
        ->addColumn('action', function($row){
            if($row->status == '1'){
                $action = '<a href="'.route('admin.shopping_slider_status', ['sId' => encrypt($row->id), 'status'=> encrypt(2)]).'" class="btn btn-danger">Disable</a>';
            }else{
                $action = '<a href="'.route('admin.shopping_slider_status', ['sId' => encrypt($row->id), 'status'=> encrypt(1)]).'" class="btn btn-primary">Enable</a>';
            }
                $action .= '<a  href="'.route('admin.shopping_slider_edit', ['id' => encrypt($row->id)]).'" class="btn btn-info">Edit</a>';
            return $action;
        })
        ->rawColumns(['action', 'slider_image'])
        ->make(true);
    }

    public function storeShoppingSlider(Request $request)
    {
        $this->validate($request, [
            'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $slider_name = $request->input('slider_name');
        $image = null;
        if($request->hasfile('slider_image')){
            $image_array = $request->file('slider_image');
            $image = $this->sliderImageInsert($image_array, $request, 1);
        }
        $offer = $request->input('offer');
        $banner_title = $request->input('banner_title');
        $banner_subtitle = $request->input('banner_subtitle');

        $shopping_slider_insert = new ShoppingSlider;
        $shopping_slider_insert->slider_name = $slider_name;
        $shopping_slider_insert->slider_image = $image;
        $shopping_slider_insert->offer = $offer;
        $shopping_slider_insert->banner_title = $banner_title;
        $shopping_slider_insert->banner_subtitle = $banner_subtitle;

        if($shopping_slider_insert->save()){
            return redirect()->back()->with('message', 'Slider Inserted Successfully!');
        }else {
            return redirect()->back()->with('error', 'Something Went Wrong Please Try Again');
        }
    }
    public function ShoppingSliderEdit($pId){
        try{
            $id = decrypt($pId);
        }catch(DecryptException $e) {
            abort(404);
        }
        $slider = ShoppingSlider::find($id);
        return view('admin.frontend.edit_slider', compact('slider'));
    }

    public function ShoppingSliderStatus($sId,$statusId){
        try{
            $id = decrypt($sId);
            $sId = decrypt($statusId);
        }catch(DecryptException $e) {
            abort(404);
        }

        $shopping_slider_status = ShoppingSlider::where('id', $id)
            ->update(['status' => $sId, 'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()]);
       if($shopping_slider_status){
           return redirect()->back()->with('message','Status Updated Successfully!');
       }
    }

    public function ShoppingSliderUpdate(Request $request)
    {   
       
        $this->validate($request, [
            'slider_name'   => 'required',
            'offer' => 'required',
            'banner_title' => 'required',
        ]);
        $id = $request->input('id');
        $image1 = null;
        if($request->hasfile('slider_image'))
        {
            $this->validate($request, [
                'slider_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            $logo_array = $request->file('slider_image');
            $image1 = $this->imageInsert($logo_array, $request, 1);
           
            // Check wheather image is in DB
            $checkImage = DB::table('shopping_sliders')->where('id', $id)->first();
            if($checkImage){
                //Delete
                $image_path_thumb = "/public/admin/photo/thumb/".$checkImage->slider_image;  
                $image_path_original = "/public/admin/photo/".$checkImage->slider_image;  
                if(File::exists($image_path_thumb)) {
                    File::delete($image_path_thumb);
                }
                if(File::exists($image_path_original)){
                    File::delete($image_path_original);
                }

                //Update
                $image_update = DB::table('shopping_sliders')
                ->where('id', $id)
                ->update([
                    'slider_image' => $image1,
                    'updated_at' => Carbon::now()
                ]);   
                if($image_update){
                    return redirect()->back()->with('message','Product Updated Successfully!');
                }
            }else{
                 //Update
                 $image_update = DB::table('shopping_sliders')
                 ->where('id', $id)
                 ->update([
                     'slider_image' => $image1,
                     'updated_at' => Carbon::now()
                 ]);   
                if($image_update){
                        return redirect()->back()->with('message','Product Updated Successfully!');
                    }
            }
        }
        $shopping_slider = ShoppingSlider::find($id);
        $shopping_slider->slider_name = $request->input('slider_name');
        $shopping_slider->offer = $request->input('offer');
        $shopping_slider->banner_title = $request->input('banner_title');
        $shopping_slider->banner_subtitle = $request->input('banner_subtitle');
        $update = $shopping_slider->save();

        if($update){
            return redirect()->back()->with('message','Product Slider Successfully!');
        }
    }

    public function shoppingProduct(){
        return view('admin.shopping_product.index');
    }

    public function addShoppingProduct(){
        return view('admin.shopping_product.create');
    }

    public function storeShoppingProduct(Request $request){
        $this->validate($request, [
            'name'   => 'required',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mrp' => 'required|min:1|numeric',
            'price'   => 'required|min:1|numeric',
        ]);

        $name = $request->input('name');
        $image = null;
        if($request->hasfile('main_image')){
            $image_array = $request->file('main_image');
            $image = $this->imageInsert($image_array, $request, 1);
        }
        $mrp = $request->input('mrp');
        $price = $request->input('price');
        $short_desc = $request->input('short_desc');
        $long_desc = $request->input('long_desc');

        $shopping_product_insert = new ShoppingProduct;
        $shopping_product_insert->name = $name;
        $shopping_product_insert->main_image = $image;
        $shopping_product_insert->mrp = $mrp;
        $shopping_product_insert->price = $price;
        $shopping_product_insert->short_desc = $short_desc;
        $shopping_product_insert->long_desc = $long_desc;
        $save = $shopping_product_insert->save();
        if($save){
            return redirect()->back()->with('message','Product Added Successfully!');
        }
    }

    public function ShoppingProductList(){
        return datatables()->of(ShoppingProduct::get())
        ->addIndexColumn()
        ->addColumn('main_image', function($row){
            if($row->main_image){
                $main_image = '<img src="'.asset("admin/photo/".$row->main_image).'" width="50"/>';
            }
            return $main_image;
        })
        ->addColumn('action', function($row){
            if($row->status == '1'){
                $action = '<a href="'.route('admin.shopping_product_status', ['pId' => encrypt($row->id), 'status'=> encrypt(2)]).'" class="btn btn-danger">Disable</a>';
            }else{
                $action = '<a href="'.route('admin.shopping_product_status', ['pId' => encrypt($row->id), 'status'=> encrypt(1)]).'" class="btn btn-primary">Enable</a>';
            }
                $action .= '<a  href="'.route('admin.shopping_product_edit', ['id' => encrypt($row->id)]).'" class="btn btn-info">Edit</a>';
            return $action;
        })
        ->rawColumns(['action', 'main_image'])
        ->make(true);
    }

    public function ShoppingProductEdit($pId){
        try{
            $id = decrypt($pId);
        }catch(DecryptException $e) {
            abort(404);
        }
        $product = ShoppingProduct::find($id);
        return view('admin.shopping_product.edit', compact('product'));
    }

    public function ShoppingProductStatus($pId,$statusId){
        try{
            $id = decrypt($pId);
            $sId = decrypt($statusId);
        }catch(DecryptException $e) {
            abort(404);
        }

        $shopping_product_status = ShoppingProduct::where('id', $id)
            ->update(['status' => $sId, 'updated_at' => Carbon::now()]);
       if($shopping_product_status){
           return redirect()->back()->with('message','Status Updated Successfully!');
       }
    }

    public function ShoppingProductUpdate(Request $request){
        $this->validate($request, [
            'name'   => 'required',
            'mrp' => 'required|min:1|numeric',
            'price'   => 'required|min:1|numeric'
        ]);
        $id = $request->input('product_id');
        $name = $request->input('name');
        if($request->hasfile('main_image'))
        {
            $this->validate($request, [
                'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            $main_image_array = $request->file('main_image');
            $image1 = $this->imageInsert($main_image_array, $request, 1);
           
            // Check wheather image is in DB
            $checkImage = DB::table('shopping_product')->where('id', $id)->first();
            if($checkImage->main_image){
                //Delete
                $image_path_thumb = "/public/admin/photo/thumb/".$checkImage->image;  
                $image_path_original = "/public/admin/photo/".$checkImage->image;  
                if(File::exists($image_path_thumb)) {
                    File::delete($image_path_thumb);
                }
                if(File::exists($image_path_original)){
                    File::delete($image_path_original);
                }

                //Update
                $image_update = DB::table('shopping_product')
                ->where('id', $id)
                ->update([
                    'main_image' => $image1,
                    'updated_at' => Carbon::now()
                ]);   

                if($image_update){
                        return redirect()->back()->with('message','Product Updated Successfully!');
                    }
            }else{
                 //Update
                 $image_update = DB::table('shopping_product')
                 ->where('id', $id)
                 ->update([
                     'main_image' => $image1,
                     'updated_at' => Carbon::now()
                 ]);   
                if($image_update){
                        return redirect()->back()->with('message','Product Updated Successfully!');
                    }
            }
        }
        $mrp = $request->input('mrp');
        $price = $request->input('price');
        $short_desc = $request->input('short_desc');
        $long_desc = $request->input('long_desc');

        $shopping_product = ShoppingProduct::find($id);
        $shopping_product->name = $name;
        $shopping_product->mrp = $mrp;
        $shopping_product->price = $price;
        $shopping_product->short_desc = $short_desc;
        $shopping_product->long_desc = $long_desc;
        $update = $shopping_product->save();

        if($update){
            return redirect()->back()->with('message','Product Updated Successfully!');
        }

    }

    function imageInsert($image, Request $request, $flag){
        $destination = base_path().'/public/admin/photo/';
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(date('now').time()).$flag.".".$image_extension;
        $original_path = $destination.$image_name;
        Image::make($image)->save($original_path);
        $thumb_path = base_path().'/public/admin/photo/thumb/'.$image_name;
        Image::make($image)
        ->resize(300, 400)
        ->save($thumb_path);

        return $image_name;
    }

    function sliderImageInsert($image, Request $request, $flag){
        $destination = base_path().'/public/admin/photo/';
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(date('now').time()).$flag.".".$image_extension;
        $original_path = $destination.$image_name;
        Image::make($image)->save($original_path);
        return $image_name;
    }
}
