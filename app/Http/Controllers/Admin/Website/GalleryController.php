<?php

namespace App\Http\Controllers\Admin\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function gallery()
    {
        return view('admin.gallery');
    }
    public function storeGallery(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $gallery = new Gallery();
        $image = null;
        if($request->hasfile('photo')){
            $image_array = $request->file('photo');
            $image = $this->galleryImageInsert($image_array, $request, 1);
        }
        $gallery->photo = $image;
        if($gallery->save()){
            return redirect()->back()->with('message','Successfully added');
        }
    }

    public function galleryList()
    {
        $query = Gallery::orderBy('created_at', 'DESC');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('photo', function($row){
            if($row->photo){
                $photos = '<img src="'.asset("web/img/gallery/thumb/".$row->photo).'" width="100"/>';
            }
            return $photos;
        })
        ->addColumn('action', function($row){
            if($row->status == 1){
                $btn = '<a href="'.route('admin.gallery_status', ['id' => encrypt($row->id), 'status'=> 2]).'" class="btn btn-warning btn-sm"><i class="fa fa-power-off"></i></a>';
            }else{
                $btn = '<a href="'.route('admin.gallery_status', ['id' => encrypt($row->id), 'status'=> 1]).'" class="btn btn-primary btn-sm"><i class="fa fa-check"></i></a>';
            }
            $btn .= '<a href="'.route('admin.gallery_delete', ['id' => encrypt($row->id)]).'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['action', 'photo'])
        ->make(true);
    }
    public function galleryDelete($id){
        try{
            $id = decrypt($id);
        }catch(DecryptException $e) {
            abort(404);
        }
        $gallery = Gallery::find($id);
        $delete = Gallery::where('id', $id)->delete();
        if($delete){
            File::delete(public_path().'/web/img/gallery/'.$gallery->photo);
            File::delete(public_path().'/web/img/gallery/thumb/'.$gallery->photo);
            return redirect()->back()->with('message','Gallery Deleted Successfully!');
        }else{
            return redirect()->back()->with('error','Something Went wrong!');
        }
    }
    public function galleryStatus($id, $status){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $gallery = Gallery::find($id);
        $gallery->status = $status;
        if($gallery->save()){
            return redirect()->back()->with('message','Status Updated Successfully!');
        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }
}
