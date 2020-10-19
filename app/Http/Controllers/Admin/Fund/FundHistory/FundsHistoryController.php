<?php

namespace App\Http\Controllers\Admin\Fund\FundHistory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WalletHistory;
use App\Models\Member;
class FundsHistoryController extends Controller
{
    public function fundHistory($user_id){
        try{
            $user_id = decrypt($user_id);
        }catch(DecryptException $e) {
            abort(404);
        }
        return view('admin.fund.fund_history', compact('user_id'));
    }

    public function fundHistoryList($user_id){
        $query = WalletHistory::where('user_id', $user_id)->latest()->orderBy('created_at', 'DESC');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('name', function($row){
            $member = Member::find($row->user_id);
            $name = $member->name;
            return $name;
        })
        ->editColumn('amount', function ($row) {
            return number_format($row->amount, 2);
        })
        ->editColumn('total_amount', function ($row) {
            return number_format($row->total_amount, 2);
        })
        ->rawColumns(['name', 'total_amount'])
        ->make(true);
    }
}
