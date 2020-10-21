<?php

namespace App\Http\Controllers\Member\Downline;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DownlineController extends Controller
{
    public function index(){
        return view('member.downline.index');
    }

    public function downline(){
        return datatables()->of(DB::select(DB::raw("SELECT * FROM (SELECT * FROM tree
            ORDER BY user_id) items_sorted,
           (SELECT @iv := :user_id) initialisation
           WHERE find_in_set(parent_id, @iv)
           AND length(@iv := concat(@iv, ',', id))"),
            array(
                'user_id' => Auth::guard('member')->user()->id,
                )))
            ->addIndexColumn()
            ->addColumn('member_id', function($row){
                $user_id = $row->user_id;
                if(!empty($user_id)){
                    $member_id =  DB::table('tree')
                        ->select('members.sponsor_id as sponsor_id')
                        ->join('members', 'members.id', '=', 'tree.user_id')
                        ->where('tree.user_id', $row->user_id)
                        ->value('members.sponsor_id');
                }
                return $member_id;
            })
            ->addColumn('parent', function($row){
                $parents = $row->parent_id;
                if (!empty($parents)) {
                    $parent_details =  DB::table('tree')
                    ->select('members.name as u_name','members.id as u_id', 'members.sponsor_id as sponsor_id')
                    ->join('members','members.id','=','tree.user_id')
                    ->where('tree.id',$row->parent_id)
                    ->first();
                   $parent = $parent_details->sponsor_id;
                   if ($row->user_id == $parent_details->u_id) {
                        $parent .=" (Self)";
                    }else{
                        $parent .=" (".$parent_details->u_name.")";
                   }
                   return $parent;
                }
            })
            ->addColumn('member_name', function($row){
                $member_name = null;
                if (!empty($row->user_id)) {
                    $member_details =  DB::table('members')
                    ->select('name','id')
                    ->where('id',$row->user_id)
                   ->first();
                   $member_name =$member_details->name;
                }
                return $member_name;
            })
            ->addColumn('left_member', function($row){
                $lft_members = $row->left_id;
                if (!empty($lft_members)) {
                    $lft_details =  DB::table('tree')
                   ->select('members.name as u_name','members.id as u_id', 'members.sponsor_id as sponsor_id')
                   ->join('members','members.id','=','tree.user_id')
                   ->where('tree.id',$lft_members)
                   ->first();
                    $lft_member = $lft_details->sponsor_id;
                   if ($row->user_id == $lft_details->u_id) {
                        $lft_member.=" (Self)";
                    }else{
                        $lft_member.=" (".$lft_details->u_name.")";
                   }
                   return $lft_member;
                }
            })
            ->addColumn('right_member', function($row){
                $rht_members = $row->right_id;
               
                if (!empty($rht_members)) {
                    $rht_details =  DB::table('tree')
                    ->select('members.name as u_name','members.id as u_id', 'members.sponsor_id as sponsor_id')
                   ->join('members','members.id','=','tree.user_id')
                   ->where('tree.id',$rht_members)
                   ->first();
                    $rht_member = $rht_details->sponsor_id;
                   if ($row->user_id == $rht_details->u_id) {
                        $rht_member.=" (Self)";
                    }else{
                        $rht_member.=" (".$rht_details->u_name.")";
                    }
                    return $rht_member;
                }
            })
            ->addColumn('add_by', function($row){
                $add_by = $row->registered_by;
                if (!empty($add_by)) {
                    if (substr($add_by, -1) == "A") {
                    $add_by = "ADMIN";
                }elseif($row->user_id == $add_by){
                    $add_by = "SELF";
                  }else{
                      $user_details =  DB::table('members')
                        ->select('name','id', 'sponsor_id')
                        ->where('id',$add_by)
                        ->first();
                        $add_by = $user_details->sponsor_id;
                        $add_by.= "(".$user_details->name.")";
                    }
                }
                return $add_by;
            })
            ->addColumn('created_at', function($row){
                $created_at = Carbon::parse($row->created_at)->toDayDateTimeString();
                return $created_at;
            })
            ->rawColumns(['parent','member_name','left_member','right_member','add_by','created_at'])
            ->make(true);
    }
}
