<?php

namespace App\Http\Controllers\Admin\Fund;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Wallet;
use App\Models\WalletHistory;
use DB;
class FundsController extends Controller
{
    public function index(){
        return view('admin.fund.index');
    }

    public function fund(){
        return view('admin.fund.fund');
    }

    public function allocateFund(Request $request){
        $validatedData = $request->validate([
            'fund' => 'required|numeric',
            'sponsorID' => 'required'
        ]);
        $fund = $request->input('fund');
        $member_id = $request->input('sponsorID');
        $member_data = Member::where('sponsor_id', $member_id)->first();
        $wallet = Wallet::where('user_id', $member_data->id)->first();
        $wallet->amount = ($wallet->amount + $fund);
        try {
            DB::transaction(function () use($wallet, $member_data, $fund) {
                if($wallet->save()){
                    $wallet_history = new WalletHistory;
                    $wallet_history->wallet_id = $wallet->id;
                    $wallet_history->user_id = $member_data->id;
                    $wallet_history->transaction_type = '1';
                    $wallet_history->amount = $fund;
                    $wallet_history->comment = "Rs. ". number_format($fund, 2)." is successfully credited to yoour account";
                    $wallet_history->total_amount = $wallet->amount;
                    $wallet_history->save();
                }
            });
            return redirect()->back()->with('message', ''.$fund.' Fund is transfered successfully to '.$member_data->name.'');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong! Please Try After Sometime');
        }

        
    }

    public function searchMemberID(Request $request){
        if($request->ajax()){
            $member_id = $request->get('query');
            if (!empty($member_id)) {
                $member_data = Member::where('sponsor_id', $member_id)->first();
                if($member_data) {
                    $html = '
                    <label for="name">Name</label>
                    <input type="text" value="'.$member_data->name.'" class="form-control" readonly placeholder="Name">
                    <label for="gender">Mobile</label>
                    <input type="text" value="'.$member_data->mobile.'" class="form-control" readonly placeholder="Mobile">
                    <label for="gender">DOB</label>
                    <input type="text" value="'.$member_data->dob.'" class="form-control" readonly placeholder="DOB"><br>
                    <label for="name">How much fund you are allocating?</label>
                    <input type="number" class="form-control" name="fund"  placeholder="How much fund you are allocating?"><br>
                    ';
                    echo $html;
                }
                else{
                    return 5;
                }
            }  
            else{
                return 1;
            }
        }
        else{
            return 9;
        }
    }

    public function show(){
        $query = Wallet::latest()->orderBy('created_at', 'DESC');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('name', function($row){
            $member = Member::find($row->user_id);
            $name = $member->name;
            return $name;
        })
        ->addColumn('action', function($row){
            $action = '<a href="'.route('admin.fund_history', ['id' => encrypt($row->user_id)]).'" target="_blank" class="btn btn-warning">Fund History</a>';
            return $action;
        })
        ->editColumn('amount', function ($row) {
            return number_format($row->amount, 2);
        })
        ->rawColumns(['action', 'name', 'amount'])
        ->make(true);
    }
}
