<?php

namespace App\Http\Controllers\Member\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Member;
use Auth;
class OrderController extends Controller
{
    public function index(){
        return view('member.orders.index');
    }

    public function ordersList(){
        $query = Order::latest()->where('user_id', Auth::guard('member')->user()->id);
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('product', function($row){
            $product = Product::find($row->product_id);
            return $product->name;
        })
        ->addColumn('product_image', function($row){
            $url= asset('public/product/'.$row->image);
            $product = Product::find($row->product_id);
            return '<img src="'.$url.'" alt="Photo"/>';
        })
        ->editColumn('amount', function ($row){
            return number_format($row->amount, 2);
        })
        ->rawColumns(['product', 'product_image', 'amount'])
        ->make(true);
    }
}
