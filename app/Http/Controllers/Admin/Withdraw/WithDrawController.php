<?php

namespace App\Http\Controllers\Admin\Withdraw;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\DB;

class WithDrawController extends Controller
{
    public function index(){
        return view('admin.withdraw.index');
    }

    public function list(){
          $query = WithdrawRequest::latest();
          return datatables()->of($query->get())
          ->addIndexColumn()
          ->editColumn('amount', function($row){
               return number_format($row->amount, 2);
          })
          ->addColumn('name', function($row){
               $member = Member::find($row->user_id);
               return $member->name;
          })
          ->addColumn('action', function($row){
               if($row->status == '1'){
                    $btn = '<a href="'.route('admin.withdraw_status', ['id' => encrypt($row->id), 'status' => 2]).'" class="btn btn-primary btn-sm">Pay Now</a>
                    <a href="'.route('admin.withdraw_status', ['id' => encrypt($row->id), 'status' => 1]).'" class="btn btn-danger btn-sm">Reject</a>';
                    return $btn;
               }else{
                    $btn ='<a href="#" class="btn btn-success btn-sm" disabled>Paid</a>';
                    return $btn;
               }
          })
          ->rawColumns(['amount','action'])
          ->make(true);
     }

     public function status($id, $status){
          try {
               $id = decrypt($id);
          } catch (\Exception $e) {
               abort(404);
          }
          $withdraw = WithdrawRequest::find($id);
          $withdraw->status = $status;
          if($id == 1){
               try {
                    DB::transaction(function () use ($withdraw) {
                         $user_id = $withdraw->user_id;
                         $wallet = Wallet::where('user_id', $user_id)->first();
                         $wallet->amount = ($wallet->amount + $withdraw->amount);

                         $wallet_history = new WalletHistory;
                         $wallet_history->wallet_id = $wallet->id;
                         $wallet_history->user_id = $user_id;
                         $wallet_history->transaction_type = 1;
                         $wallet_history->amount = $withdraw->amount;
                         $wallet_history->total_amount = ($wallet->amount + $withdraw->amount);
                         $wallet_history->comment = 'Rs '.number_format($withdraw->amount, 2).' is successfully credited to your wallet.';
                         $wallet->save();
                         $wallet_history->save();
                         $withdraw->save();
                    });
                    return redirect()->back()->with('message', 'Status Update Successfully!');
               } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Something went wrong!');
               }
          }else {
               if($withdraw->save()){
                    return redirect()->back()->with('message', 'Status Update Successfully!');
               }else {
                    return redirect()->back()->with('error', 'Something went wrong!');
               }
          }
     }
}
