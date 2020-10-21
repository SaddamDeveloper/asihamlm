<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminWallet;
use App\Models\Member;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardView()
    {
        $total_members = Member::count();
        $total_member_wallet_balance = Wallet::sum('amount');
        $admin_wallet_bal = AdminWallet::value('amount');
        $latest_members = Member::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.dashboard', compact('total_members', 'total_member_wallet_balance', 'admin_wallet_bal', 'latest_members'));
    }
    
    public function profile(){
        $member = Member::findOrFail(Auth::guard('member')->user()->id);
        return view('member.profile', compact('member'));
    }
}
