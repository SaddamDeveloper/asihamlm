<?php

namespace App\Http\Controllers\Admin\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FrontendController extends Controller
{
    public function info(){
        $info = Frontend::first();
        return view('admin.frontend.info', compact('info'));
    }
    public function storeInfo(Request $request){
        $id = $request->input('id');
        $image1 = null;
        if($request->hasfile('logo'))
        {
            $this->validate($request, [
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
            $logo_array = $request->file('logo');
            $image1 = $this->imageInsert($logo_array, $request, 1);
           
            // Check wheather image is in DB
            $checkImage = DB::table('frontends')->where('id', $id)->first();
            if($checkImage){
                //Delete
                $image_path_thumb = "/public/admin/photo/thumb/".$checkImage->logo;  
                $image_path_original = "/public/admin/photo/".$checkImage->logo;  
                if(File::exists($image_path_thumb)) {
                    File::delete($image_path_thumb);
                }
                if(File::exists($image_path_original)){
                    File::delete($image_path_original);
                }

                //Update
                $image_update = DB::table('frontends')
                ->where('id', $id)
                ->update([
                    'logo' => $image1,
                    'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()
                ]);   
                if($image_update){
                    return redirect()->back()->with('message','Product Updated Successfully!');
                }
            }else{
                 //Update
                 $image_update = DB::table('frontends')
                 ->where('id', $id)
                 ->update([
                     'logo' => $image1,
                     'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()
                 ]);   
                if($image_update){
                        return redirect()->back()->with('message','Product Updated Successfully!');
                    }
            }
        }
        $frontend = DB::table('frontends')
                 ->update([
                     'footer_text' => $request->input('footer'),
                     'footer_address' => $request->input('address'),
                     'email' => $request->input('email'),
                     'mobile' => $request->input('mobile'),
                     'fb_id' => $request->input('fb_id'),
                     'tw_id' => $request->input('tw_id'),
                     'insta_id' => $request->input('insta_id'),
                     'yt_id' => $request->input('yt_id'),
                     'updated_at' => Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString()
                 ]);   
        if($frontend){
            return redirect()->back()->with('message','Successfully Updated Successfully');
        }
    }

    private function imageInsert($image, Request $request, $flag){
        $destination = base_path().'/public/admin/photo/';
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(date('now').time()).$flag.".".$image_extension;
        $original_path = $destination.$image_name;
        Image::make($image)->save($original_path);
        $thumb_path = base_path().'/public/admin/photo/thumb/'.$image_name;
        Image::make($image)
        ->resize(242, 136)
        ->save($thumb_path);

        return $image_name;
    }
}
