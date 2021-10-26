<?php

namespace App\Http\Controllers\Admin\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Legal;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class LegalController extends Controller
{
    public function legal(){
        return view('admin.gallery.legal');
    }
    public function storeLegal(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'document' => 'required|mimes:pdf|max:10000'
        ]);
        $legal = new Legal;
        $image = null;
        if($request->hasfile('photo')){
            $image_array = $request->file('photo');
            $image = $this->galleryImageInsert($image_array, 1);
        }
        if($request->hasFile('document')){
            $file = $request->file('document');
            $filename = time() . '.' . $request->file('document')->extension();
            $filePath = public_path() . '/web/documents/';
            $file->move($filePath, $filename);
        }
        $legal->name = $request->name;
        $legal->photo = $image;
        $legal->documents = $filename;
        if($legal->save()){
            return redirect()->back()->with('message','Successfully added');
        }
    }
    public function legalList(){
        return datatables()->of(Legal::orderBy('created_at', 'DESC')->get())
        ->addIndexColumn()
        ->addColumn('photo', function($row){
            if($row->photo){
                $photos = '<img src="'.asset("legal/thumb/".$row->photo).'" width="100"/>';
            }
            return $photos;
        })
        ->addColumn('document', function($row){
            if($row->documents){
                $document = '<a href="'.asset("legal/documents/".$row->documents).'">Document</a>';
            }
            return $document;
        })
        ->addColumn('action', function($row){
            if($row->status == '1'){
                $action = '<a href="'.route('admin.legal_action', ['id' => encrypt($row->id), 'status'=> 2]).'" class="btn btn-warning">Disable</a>';
            }else{
                $action = '<a href="'.route('admin.legal_action', ['id' => encrypt($row->id), 'status'=> 1]).'" class="btn btn-primary">Enable</a>';
            }
            $action .= '<a  href="'.route('admin.legal_delete', ['id' => encrypt($row->id)]).'" class="btn btn-danger">Delete</a>';
            return $action;
        })
        ->rawColumns(['action', 'photo', 'document'])
        ->make(true);
    }
    public function legalAction($id, $status){
        try{
            $id = decrypt($id);
        }catch(DecryptException $e) {
            abort(404);
        }
        $legal = Legal::find($id);
        $legal->status = $status;
        if($legal->save()){
            return redirect()->back()->with('message','Status Updated Successfully!');
        }else{
            return redirect()->back()->with('error','Something Went Wrong!');
        }
    }
    public function legalDelete($id){
        try{
            $id = decrypt($id);
        }catch(DecryptException $e) {
            abort(404);
        }
        $legal = Legal::find($id);
        $delete = Legal::where('id', $id)->delete();
        if($delete){
            File::delete(public_path().'/legal/'.$legal->photo);
            File::delete(public_path().'/legal/thumb/'.$legal->photo);
            File::delete(public_path().'/legal/documents/'.$legal->documents);
            return redirect()->back()->with('message','Legal Deleted Successfully!');
        }else{
            return redirect()->back()->with('error','Something Went wrong!');
        }
    }

    function galleryImageInsert($image, $flag){
        $destination = base_path().'/public/legal/';
        $image_extension = $image->getClientOriginalExtension();
        $image_name = md5(date('now').time()).$flag.".".$image_extension;
        $original_path = $destination.$image_name;
        Image::make($image)->save($original_path);
        $thumb_path = base_path().'/public/legal/thumb/'.$image_name;
        Image::make($image)
        ->resize(300, 400)
        ->save($thumb_path);

        return $image_name;
    }
}
