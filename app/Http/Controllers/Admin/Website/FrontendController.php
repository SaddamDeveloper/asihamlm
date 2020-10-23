<?php

namespace App\Http\Controllers\Admin\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
            $checkImage = DB::table('frotends')->where('id', $id)->first();
            if($checkImage){
                //Delete
                $image_path_thumb = "/public/web/img/product/thumb/".$checkImage->logo;  
                $image_path_original = "/public/web/img/product/".$checkImage->logo;  
                if(File::exists($image_path_thumb)) {
                    File::delete($image_path_thumb);
                }
                if(File::exists($image_path_original)){
                    File::delete($image_path_original);
                }

                //Update
                $image_update = DB::table('frotends')
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
                 $image_update = DB::table('frotends')
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
        $frontend = DB::table('frotends')
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
}
