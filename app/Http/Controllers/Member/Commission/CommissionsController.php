<?php

namespace App\Http\Controllers\Member\Commission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommissionHistory;
use Auth;
class CommissionsController extends Controller
{
    public function index(){
        return view('member.commission.index');
    }

    public function commission(){
        $query = CommissionHistory::latest()->where('user_id', Auth::guard('member')->user()->id);
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->editColumn('amount', function($row){
            return number_format($row->amount, 2);
        })
        ->rawColumns(['amount'])
        ->make(true);
    }
}
