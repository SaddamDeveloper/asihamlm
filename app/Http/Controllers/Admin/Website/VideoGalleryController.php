<?php

namespace App\Http\Controllers\Admin\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class VideoGalleryController extends Controller
{
    public function videoGallery(){
        return view('admin.gallery.video_gallery');
    }
    public function storeVideoGallery(Request $request){
        $this->validate($request, [
            'youtube_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $video_gallery = new VideoGallery();
        $image = null;
        if($request->hasfile('photo')){
            $image_array = $request->file('photo');
            $image = $this->galleryImageInsert($image_array, 1);
        }
        $video_gallery->photo = $image;
        $video_gallery->youtube_id = $request->input('youtube_id');
        if($video_gallery->save()){
            return redirect()->back()->with('message','Successfully added');
        }
    }
    public function videoGalleryList(){
        return datatables()->of(VideoGallery::orderBy('created_at', 'DESC')->get())
        ->addIndexColumn()
        ->addColumn('photo', function($row){
            if($row->photo){
                $photos = '<a href="https://youtube.com/watch?v='.$row->youtube_id.'" target="_blank"><img src="'.asset("video/gallery/thumb/".$row->photo).'" width="100"/>';
            }
            return $photos;
        })
       
        ->addColumn('action', function($row){
            if($row->status == '1'){
                $action = '<a href="'.route('admin.video_gallery_status', ['id' => encrypt($row->id), 'status'=> 2]).'" class="btn btn-warning">Disable</a>';
            }else{
                $action = '<a href="'.route('admin.video_gallery_status', ['id' => encrypt($row->id), 'status'=> 1]).'" class="btn btn-primary">Enable</a>';
            }
            $action .= '<a  href="'.route('admin.video_gallery_delete', ['id' => encrypt($row->id)]).'" class="btn btn-danger">Delete</a>';
            return $action;
        })
        ->rawColumns(['action', 'photo'])
        ->make(true);
    }
    public function videoGalleryStatus($id, $status){
        try{
            $id = decrypt($id);
        }catch(DecryptException $e) {
            abort(404);
        }
        $videoGallery = VideoGallery::find($id);
        $videoGallery->status = $status;
        if($videoGallery->save()){
            return redirect()->back()->with('message','Status Updated Successfully!');
        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }
    public function videoGalleryDelete($id){
        try{
            $id = decrypt($id);
        }catch(DecryptException $e) {
            abort(404);
        }
        $videoGallery = VideoGallery::find($id);
        $delete = VideoGallery::where('id', $id)->delete();
        if($delete){
            File::delete(public_path().'/video/gallery/'.$videoGallery->photo);
            File::delete(public_path().'/video/gallery/thumb/'.$videoGallery->photo);
            return redirect()->back()->with('message','Video Gallery Deleted Successfully!');
        }else{
            return redirect()->back()->with('error','Something Went wrong!');
        }
    }

    function galleryImageInsert($image, $flag){
        $destination = base_path().'/public/video/gallery/';
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(date('now').time()).$flag.".".$image_extension;
        $original_path = $destination.$image_name;
        Image::make($image)->save($original_path);
        $thumb_path = base_path().'/public/video/gallery/thumb/'.$image_name;
        Image::make($image)
        ->resize(300, 400)
        ->save($thumb_path);

        return $image_name;
    }
}
