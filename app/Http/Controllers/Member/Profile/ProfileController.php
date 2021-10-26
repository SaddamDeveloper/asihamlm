<?php

namespace App\Http\Controllers\Member\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(){
        $member = Member::find(Auth::guard('member')->user()->id);
        return view('member.profile.index', compact('member'));
    }

    public function accountUpdate(){
        $member = Member::find(Auth::guard('member')->user()->id);
        return view('member.profile.account_update', compact('member'));
    }

    public function memberUpdate(Request $request){
        $this->validate($request, [
            'member_name'   => 'required',
            'mobile'        => 'required',
            'email'         => 'required|email',
        ]);

        $member = Member::find(Auth::guard('member')->user()->id);
        $member->name = $request->input('member_name');
        $member->mobile = $request->input('mobile');
        $member->email = $request->input('email');
        $member->dob = $request->input('dob');
        $member->pan_card = $request->input('pan');
        $member->adhar_card = $request->input('aadhar');
        $member->address = $request->input('address');
        $member->bank_name = $request->input('bank');
        $member->ifsc = $request->input('ifsc');
        $member->account_no = $request->input('account_no');

        $image = null;
        if($request->hasfile('photo')){
            $this->validate($request, [
                'photo'         =>  'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if($member->photo){
                //Delete
                $image_path_thumb = "images/thumb/".$member->photo;  
                $image_path_original = "images/".$member->photo;  
                if(File::exists($image_path_thumb)) {
                    File::delete($image_path_thumb);
                }
                if(File::exists($image_path_original)){
                    File::delete($image_path_original);
                }
            }
            $image_array = $request->file('photo');
            $image = $this->imageInsert($image_array, $request, 1);
            $member->photo = $image;
        }
        if($member->save()){
            return redirect()->back()->with('message', 'Account Updated Successfully!');
        }else{
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
    }

    function imageInsert($image, Request $request, $flag){
        $destination = base_path().'/public/images/';
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(date('now').time()).$flag.".".$image_extension;
        $original_path = $destination.$image_name;
        Image::make($image)->save($original_path);
        $thumb_path = base_path().'/public/images/thumb/'.$image_name;
        Image::make($image)
        ->resize(300, 400)
        ->save($thumb_path);

        return $image_name;
    }
}
