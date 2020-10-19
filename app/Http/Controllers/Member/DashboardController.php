<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\Tree;
use Auth;
class DashboardController extends Controller
{
    public function dashboardView()
    {
        $commission = Wallet::where('user_id', Auth::guard('member')->user()->id)->value('amount');
        $total_pair = Tree::where('user_id', Auth::guard('member')->user()->id)->value('total_pair');
        return view('member.dashboard', compact('commission', 'total_pair'));
    }
}
