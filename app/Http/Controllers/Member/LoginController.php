<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    public function showLoginForm(){
        return view('member.index', ['url' => 'member']);
    }

    public function memberLogin(Request $request){
        $this->validate($request, [
            'login_id'   => 'required',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('member')->attempt(['login_id' => $request->login_id, 'password' => $request->password])) {
            return redirect()->intended('/member/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'))->with('login_error','Email or password is incorrect');
    }

    public function logout()
    {
        Auth::guard('member')->logout();
        return redirect()->route('member.login');
    }

    public function changePasswordForm()
    {
        return view('member.change_password');
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => ['required', 'string', 'min:6'],
            'new_password' => ['required', 'string', 'min:6'],
            'confirm_password' => ['required', 'string', 'min:6', 'same:new_password'],
        ]);

        $current_password = Auth::guard('member')->user()->password;   

        if(Hash::check($request->input('current_password'), $current_password)){           
            $user_id = Auth::guard('member')->user()->id; 
            $password_change = DB::table('member')
            ->where('id',$user_id)
            ->update([
                'password' => Hash::make($request->input('confirm_password')),
                'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString(),
            ]);

            return redirect()->back()->with('message','Your Password Changed Successfully');
            
        }else{           
            return redirect()->back()->with('error','Sorry Current Password Does Not matched');
       }
    }
}
