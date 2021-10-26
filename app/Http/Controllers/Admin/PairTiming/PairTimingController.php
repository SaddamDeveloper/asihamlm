<?php

namespace App\Http\Controllers\Admin\PairTiming;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PairTiming;

class PairTimingController extends Controller
{
    public function index(){
        $pair_timing = PairTiming::paginate(10);
        return view('admin.pairtiming.pairtiming', compact('pair_timing'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'from' => 'required',
            'to'   => 'required'
        ]);
        $pair_timing = new PairTiming;
        $pair_timing->name = $request->input('name');
        $pair_timing->from = $request->input('from');
        $pair_timing->to = $request->input('to');
        
        if($pair_timing->save()){
            return redirect()->back()->with('message', 'Successfully added timeframe');
        }else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
