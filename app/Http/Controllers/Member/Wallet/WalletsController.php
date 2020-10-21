<?php

namespace App\Http\Controllers\Member\Wallet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WalletHistory;
use App\Models\Wallet;
use App\Models\Withdraw;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $wallet = Wallet::find(Auth::guard('member')->user()->id);
        return view('member.wallet.withdraw', compact('wallet'));
    }

    public function withdrawAmount(Request $request){
        $wallet = Wallet::find(Auth::guard('member')->user()->id);
        if($wallet->amount >= $request->input('amount') && $wallet->amount > 100){
            $this->validate($request, [
                'amount'   => 'required|numeric'
            ]);
            $amount = $request->input('amount');
            $id = Auth::guard('member')->user()->id;
            $withdraw = new Withdraw();
            $withdraw->amount = $request->input('amount');
            $withdraw->user_id = $id;
            try {
                DB::transaction(function () use ($wallet, $withdraw, $amount, $id){
                    $withdraw->save();
                    // Deduct From Wallet
                    $wallet->amount = ($wallet->amount - $withdraw->amount);
                    $wallet->save();
                    // Wallet History
                    $wallet_history = new WalletHistory();
                    $wallet_history->wallet_id = $wallet->id;
                    $wallet_history->user_id = $id;
                    $wallet_history->transaction_type = 2;
                    $wallet_history->amount = $amount;
                    $wallet_history->total_amount = $wallet->amount;
                    $wallet_history->comment = 'Rs '.number_format($amount, 2).' has been requested to withdraw.';
                    $wallet_history->save();

                    // Withdraw requests to Admin
                    $withdraw_request = new WithdrawRequest();
                    $withdraw_request->wallet_id = $wallet->id;
                    $withdraw_request->user_id = $id;
                    $withdraw_request->amount = $amount;
                    $withdraw_request->save();
                });
                return redirect()->back()->with('message', 'Payment Request has bee successfully sent! It will confirm within 7 days');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }else {
            return redirect()->back()->with('error', 'Insufficent Balance!');
        }
    }

    public function withdrawList(){
    $query = Wallet::whereStatus(3)->where('user_id', Auth::guard('member')->user()->id)->latest();
    return datatables()->of($query->get())
    ->addIndexColumn()
    ->editColumn('amount', function ($row){
        return number_format($row->amount, 2);
    })
    ->rawColumns(['amount'])
    ->make(true);
    }
}
