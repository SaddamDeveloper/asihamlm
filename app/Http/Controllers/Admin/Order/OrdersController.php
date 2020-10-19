<?php

namespace App\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Member;
class OrdersController extends Controller
{
    public function index(){
        return view('admin.order.index');
    }

    public function list(){
        $query = Order::latest();
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('name', function($row){
            $member = Member::find($row->user_id);
            return $member->name;
        })
        ->addColumn('product', function($row){
            $product = Product::find($row->product_id);
            return $product->name;
        })
        // ->addColumn('product_image', function($row){
        //     $url= asset('public/product/'.$row->image);
        //     $product = Product::find($row->product_id);
        //     return '<img src="'.$url.'" alt="Photo"/>';
        // })
        ->editColumn('amount', function ($row){
            return number_format($row->amount, 2);
        })
        ->rawColumns(['name', 'product', 'product_image', 'amount'])
        ->make(true);
    }
}
