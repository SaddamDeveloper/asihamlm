<?php

namespace App\Http\Controllers\Admin\Commission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commission;
use DB;
use Carbon\Carbon;

class CommissionsController extends Controller
{
    
    public function index(){
        $commission = Commission::value('commission');
        return view('admin.commission.index', compact('commission'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'commission' => 'required|numeric'
        ]);

        $commission = DB::table('commissions')
        ->update([
            'commission' => $request->input('commission'),
            'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()
        ]);
        if($commission){
            return redirect()->back()->with('message', 'Commission Updated Successfully!');
        }else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
