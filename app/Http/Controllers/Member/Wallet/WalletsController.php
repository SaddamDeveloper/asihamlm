<?php

namespace App\Http\Controllers\Member\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WalletHistory;
use App\Models\Wallet;
use Auth;
class WalletsController extends Controller
{
    public function index(){
        $wallet = Wallet::where('user_id', Auth::guard('member')->user()->id)->first();
        return view('member.wallet.wallet', compact('wallet'));
    }

    public function walletList(){
        $query = WalletHistory::latest()->where('user_id', Auth::guard('member')->user()->id);
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->editColumn('amount', function($row){
            return number_format($row->amount, 2);
        })
        ->editColumn('total_amount', function($row){
            return number_format($row->total_amount, 2);
        })
        ->rawColumns(['amount', 'total_amount'])
        ->make(true);
    }

    public function walletBalance(){
        return view('member.wallet.wallet_balance');
    }

    public function withdraw(){
        return view('member.wallet.withdraw');
    }
    
}
