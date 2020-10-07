<?php

namespace App\Http\Controllers\Member\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    public function index(){
        return view('member.register.index');
    }
}
