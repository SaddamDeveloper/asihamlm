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
        ->addColumn('full_name', function($row){
            $member = Member::find($row->user_id);
            return $member->name;
        })
        ->addColumn('product', function($row){
            $product = Product::find($row->product_id);
            return $product->name;
        })
        ->addColumn('product_image', function($row){
            $product = Product::find($row->product_id);
            $url= asset('product/thumb/'.$product->image);
            return '<img src="'.$url.'" alt="Photo" height="150" width="200"/>';
        })
        ->editColumn('amount', function ($row){
            return number_format($row->amount, 2);
        })
        ->rawColumns(['full_name', 'product', 'product_image', 'amount'])
        ->make(true);
    }
}
