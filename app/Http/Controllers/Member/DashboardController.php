<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Wallet;
use App\Models\Tree;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardView()
    {
        $commission = Wallet::where('user_id', Auth::guard('member')->user()->id)->value('amount');
        $tree = Tree::where('user_id', Auth::guard('member')->user()->id)->first();
        $member = Member::find(Auth::guard('member')->user()->id);
        $downline = DB::select(DB::raw("SELECT * FROM (SELECT * FROM tree
        ORDER BY user_id) items_sorted,
       (SELECT @iv := :user_id) initialisation
       WHERE find_in_set(parent_id, @iv) 
       AND length(@iv := concat(@iv, ',', id)) limit 10"),
        array(
           'user_id' => Auth::guard('member')->user()->id,
        ));
        
        $downline_member = collect($downline)->map(function ($row) {
            $downline_member = Member::find($row->user_id);
            return $downline_member;
        });
        $direct_member = Tree::where('registered_by', $member->id)->count();
        return view('member.dashboard', compact('commission', 'tree', 'downline_member', 'member', 'direct_member'));
    }
}
