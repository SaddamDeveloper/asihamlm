<?php

namespace App\Http\Controllers\Member\Downline;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownlineController extends Controller
{
    public function index(){
        return view('member.downline.index');
    }

    public function tree(){
        return view('member.downline.tree');
    }
}
