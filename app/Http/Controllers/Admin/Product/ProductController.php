<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        return view('admin.product.index');
    }

    public function add(){
        return view('admin.product.product');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]); 

        $name = $request->input('name');
        $price = $request->input('price');
        $image = null;
        if($request->hasfile('image'))
        {
            $image_array = $request->file('image');
            $image = $this->imageInsert($image_array, $request, 1);
        }

        $product_insert = new Product;
        $product_insert->name = $name;
        $product_insert->price =  $price;
        $product_insert->image =  $image;

        if($product_insert->save()){
            return redirect()->back()->with('message','Product Added Successfully');
        }else{
             return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        } 
    }

    public function show(){
        $query = Product::where('status', 1)->latest();
        return datatables()->of($query->get())
            ->addIndexColumn()
            ->addColumn('price', function($row){
                $amt = '<span class="label label-warning">'.number_format($row->price, 2).'</span>';
                return $amt;
            })
            ->addColumn('image', function($row){
                $image = '<img src="'.asset('/product/thumb/'.$row->image).'" alt="image" height="200"/>';
                return $image;
            })
            ->addColumn('action', function($row){
                $action = '<a href="#" class="btn btn-info>Edit</a>
                <a href="#" class="btn btn-primary>Delete</a>';
                return $action;
            })
            ->rawColumns(['price', 'image', 'action'])
            ->make(true);
    }
    // Manual Function
    
    function imageInsert($image, Request $request, $flag){
        $destination = base_path().'/public/product/';
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(date('now').time()).$flag.".".$image_extension;
        $original_path = $destination.$image_name;
        Image::make($image)->save($original_path);
        $thumb_path = base_path().'/public/product/thumb/'.$image_name;
        Image::make($image)
        ->resize(300, 400)
        ->save($thumb_path);

        return $image_name;
    }
}
