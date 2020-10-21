<?php

namespace App\Http\Controllers\Admin\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Tree;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(){
        return view('admin.members.index');
    }

    public function memberList(){
        $query = Member::orderBy('id','desc');
        return datatables()->of($query->get())
        ->addIndexColumn()
        ->addColumn('left_bv', function($row){
            $tree = Tree::where('user_id', $row->id)->first();
            return $tree->total_left_count;
         })
        ->addColumn('right_bv', function($row){
            $tree = Tree::where('user_id', $row->id)->first();
            return $tree->total_right_count;
         })
        ->addColumn('total_bv', function($row){
            $tree = Tree::where('user_id', $row->id)->first();
            return $tree->total_pair;
         })
          ->addColumn('action', function($row){
            $btn = '
            <a href="'.route('admin.member_view', ['id' => encrypt($row->id)]).'" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i></a>
            <a href="'.route('admin.member_edit', ['id' => encrypt($row->id)]).'" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-pencil"></i></a>              
            <a href="'.route('admin.member_downline', ['id' => encrypt($row->id)]).'" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-code-fork"></i></a>              
            <a href="'.route('admin.member.tree', ['rank' => 0, 'user_id' => encrypt($row->id)]).'" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-tree"></i></a>              
            <a href="'.route('admin.member.change_password', ['id' => encrypt($row->id)]).'" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-lock"></i></a>              
            ';

            if($row->status == '1'){
                 $btn .= '<a href="'.route('admin.member_status', ['id' => encrypt($row->id), 'status' => 2]).'" class="btn btn-danger btn-sm"><i class="fa fa-power-off"></i></a>';
                 return $btn;
             }else{
                 $btn .='<a href="'.route('admin.member_status', ['id' => encrypt($row->id), 'status' => 1]).'" class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>';
                 return $btn;
             }
          return $btn;
     })
     ->rawColumns(['left_bv', 'right_bv', 'total_bv', 'action', 'registered_by'])
     ->make(true);
    }

    public function memberView($id){
        try {
             $id = decrypt($id);
         }catch(DecryptException $e) {
             return redirect()->back();
         }
   
        $member = Member::findOrFail($id);
        return view('admin.members.details', compact('member'));
    }
   
    public function memberEdit($id){
        try {
             $id = decrypt($id);
         }catch(DecryptException $e) {
             return redirect()->back();
         }
   
        $member = Member::findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    public function memberUpdate(Request $request){
        $id = $request->input('id');
        $this->validate($request, [
            'f_name'                => 'required',
            'email'                 => 'required|email',
            'mobile'                => 'required' . $request->phone,
        ]);

        $f_name             = $request->input('f_name');
        $m_name             = $request->input('m_name');
        $l_name             = $request->input('l_name');
        $fullName           = $f_name . " " . $m_name ." ". $l_name;
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $dob = $request->input('dob');
        $gender = $request->input('gender');
        $pan = $request->input('pan');
        $aadhar = $request->input('aadhar');
        $address = $request->input('address');
        $bank_name = $request->input('bank_name');
        $ac_holder_name = $request->input('ac_holder_name');
        $ifsc = $request->input('ifsc');
        $account_no = $request->input('account_no');

        $member = Member::find($id);
        $member->name = $fullName;
        $member->email = $email;
        $member->mobile = $mobile;
        $member->dob = $dob;
        $member->pan_card = $pan;
        $member->gender = $gender;
        $member->adhar_card = $aadhar;
        $member->address = $address;
        $member->bank_name = $bank_name;
        $member->ac_holder_name = $ac_holder_name;
        $member->ifsc = $ifsc;
        $member->account_no = $account_no;

        if($member->save()){
            return redirect()->back()->with('message', "Information updated Successfully!");
        }
    }

    public function memberDownline($id){
        try {
                $id = decrypt($id);
            }catch(DecryptException $e) {
                return redirect()->back();
            }
    
        $member = Member::findOrFail($id);
        return view('admin.members.downline', compact('member'));
    }

    public function memberDownlineList($id){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
    
        return datatables()->of(DB::select(DB::raw("SELECT * FROM (SELECT * FROM tree
        ORDER BY user_id) items_sorted,
       (SELECT @iv := :user_id) initialisation
       WHERE find_in_set(parent_id, @iv)
       AND length(@iv := concat(@iv, ',', id))"),
        array(
           'user_id' => $id,
           )))
        ->addIndexColumn()
        ->addColumn('parent', function($row){
            $parent = $row->parent_id;
            if (!empty($parent)) {
               $parent_details =  DB::table('tree')
               ->select('members.name as u_name','members.id as u_id')
               ->join('members','members.id','=','tree.user_id')
               ->where('tree.id',$row->parent_id)
               ->first();
               if ($row->user_id == $parent_details->u_id) {
                    $parent.=" (Self)";
                }else{
                    $parent.=" (".$parent_details->u_name.")";
               }
            }
            return $parent;
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
            $lft_member = $row->left_id;
            if (!empty($lft_member)) {
                $lft_details =  DB::table('tree')
               ->select('members.name as u_name','members.id as u_id')
               ->join('members','members.id','=','tree.user_id')
               ->where('tree.id',$lft_member)
               ->first();
               if ($row->user_id == $lft_details->u_id) {
                    $lft_member.=" (Self)";
                }else{
                    $lft_member.=" (".$lft_details->u_name.")";
               }
            }
            return $lft_member;
        })
        ->addColumn('right_member', function($row){
            $rht_member = $row->right_id;
           
            if (!empty($rht_member)) {
                $rht_details =  DB::table('tree')
                ->select('members.name as u_name','members.id as u_id')
               ->join('members','members.id','=','tree.user_id')
               ->where('tree.id',$rht_member)
               ->first();
               if ($row->user_id == $rht_details->u_id) {
                    $rht_member.=" (Self)";
                }else{
                    $rht_member.=" (".$rht_details->u_name.")";
                }
            }else{
                $rht_member='';
            }
            return $rht_member;
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
                    ->select('name','id')
                    ->where('id',$add_by)
                    ->first();
                    $add_by.=$add_by." (".$user_details->name.")";
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
    
    public function memberTree($rank=null, $user_id=null){
        if (!empty($user_id)) {
            try{
                $user_id = decrypt($user_id);
            }catch(DecryptException $e) {
                abort(404);
            }
        }
        if (empty($rank)) {
            $rank = 0;
        }
        $html=null;
        $root = Tree::where('user_id', $user_id)->first();
        $html .= '
        <div class="row">
        <div class="col-md-4">
        <table class="table">
            <tr>
                <th>Left Distributor</th>
                <th>Right Distributor</th>
                <th>Total Distributor</th>
            </tr>
            <tr>
                <td>'.$root->total_left_count.'</td>
                <td>'.$root->total_right_count.'</td>
                <td>'.$root->total_pair.'</td>
            </tr>
        </table>
        </div>
        </div>
        ';

        if($root){
            $level_checking = $this->levelCheck($user_id);
            $html .= '<ul>
            <li>        
                <a href="#"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$root->member->name.'<br> ('.$level_checking.')
                    <div class="info">
                        <h5>Name : '.$root->member->name.'</h5>
                        <h5>Sponsor ID : '.$root->member->login_id.'</h5>
                        <h5>Level : '.$level_checking.'</h5>
                    </div>
                </a>';
            $rank++;
            $first_level = Tree::where('parent_id',$root->id)->orderBy('parent_leg', 'ASC')->get();
         
            if ($first_level) {
                $html.="<ul>";
                if(empty($root->left_id)){
                    $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                }
                foreach ($first_level as $key => $first) {
                    $html.="<li>";
                    if ($root->left_id == $first->id) {
                        if(!empty($first->id)){
                            $level_checking = $this->levelCheck($first->user_id);
                            $first_level_node = Tree::where('user_id', $first->user_id)->first();
                            $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($first->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$first_level_node->member->name.'<br> ('.$level_checking.')
                                <div class="info">
                                    <h5>Name : '.$first_level_node->member->name.'</h5>
                                    <h5>Sponsor ID : '.$first_level_node->member->login_id.'</h5>
                                    <h5>Level : '.$level_checking.'</h5>
                                </div>  
                            </a>';
                        }
                    } else if($root->right_id == $first->id){
                        if(!empty($first->id)){
                            $level_checking = $this->levelCheck($first->user_id);
                            $first_level_node = Tree::where('user_id', $first->user_id)->first();
                            $html.='<a href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($first->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$first_level_node->member->name.'<br> ('.$level_checking.')
                                <div class="info">
                                    <h5>Name : '.$first_level_node->member->name.'</h5>
                                    <h5>Sponsor ID : '.$first_level_node->member->login_id.'</h5>
                                    <h5>Level : '.$level_checking.'</h5>
                                </div>  
                            </a>';
                        }
                    }

                    $second_level = Tree::where('parent_id',$first->id)->orderBy('parent_leg', 'ASC')->get();

                    if ($second_level) {
                        $html.="<ul>";
                        if(empty($first->left_id)){
                            $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                        }
                        foreach ($second_level as $key => $second) {
                            $html.="<li>";
                            if ($first->left_id == $second->id) {
                                if(!empty($second->id)){
                                    $level_checking = $this->levelCheck($second->user_id);
                                    $second_level_node = Tree::where('user_id', $second->user_id)->first();
                                    $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($second->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$second_level_node->member->name.'<br> ('.$level_checking.')
                                                <div class="info">
                                                    <h5>Name : '.$second_level_node->member->name.'</h5>
                                                    <h5>Sponsor ID : '.$second_level_node->member->login_id.'</h5>
                                                    <h5>Level : '.$level_checking.'</h5>
                                                </div>  
                                            </a>';
                                }
                            } else if($first->right_id == $second->id){
                                if(!empty($second->id)){
                                    $level_checking = $this->levelCheck($second->user_id);
                                    $second_level_node =Tree::where('user_id', $second->user_id)->first();
                                    $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($second->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$second_level_node->member->name.'<br> ('.$level_checking.')
                                        <div class="info">
                                            <h5>Name : '.$second_level_node->member->name.'</h5>
                                            <h5>Sponsor ID : '.$second_level_node->member->login_id.'</h5>
                                            <h5>Level : '.$level_checking.'</h5>
                                        </div>  
                                    </a>';
                                }
                            }

                            //THIRD LEVEL STARTS
                            $third_level = Tree::where('parent_id',$second->id)->orderBy('parent_leg', 'ASC')->get();
                            
                            if ($third_level) {
                                $html.="<ul>";
                                if(empty($second->left_id)){
                                    $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                                }
                                foreach ($third_level as $key => $third) {
                                    $html.="<li>";
                                    if ($second->left_id == $third->id) {
                                        if(!empty($third->id)){
                                            $level_checking = $this->levelCheck($third->user_id);
                                            $third_level_node = Tree::where('user_id', $third->user_id)->first();
                                            $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($third->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$third_level_node->member->name.'<br> ('.$level_checking.')
                                                <div class="info">
                                                    <h5>Name : '.$third_level_node->member->name.'</h5>
                                                    <h5>Sponsor ID : '.$third_level_node->member->login_id.'</h5>
                                                    <h5>Level : '.$level_checking.'</h5>
                                                </div>  
                                            </a>';
                                        }
                                    } else if($second->right_id == $third->id){
                                        if(!empty($third->id)){
                                            $level_checking = $this->levelCheck($third->user_id);
                                            $third_level_node = Tree::where('user_id', $third->user_id)->first();
                                            $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($third->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$third_level_node->member->name.'<br> ('.$level_checking.')
                                                <div class="info">
                                                    <h5>Name : '.$third_level_node->member->name.'</h5>
                                                    <h5>Sponsor ID : '.$third_level_node->member->login_id.'</h5>
                                                    <h5>Level : '.$level_checking.'</h5>
                                                </div>  
                                            </a>';
                                        }
                                    }
                                    //FOURTH LEVEL STARTS
                                    $fourth_level = Tree::where('parent_id',$third->id)->orderBy('parent_leg', 'ASC')->get();
                                    if ($fourth_level) {
                                        $html.="<ul>";
                                        if(empty($third->left_id)){
                                            $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                                        }
                                        $count = 1;
                                        foreach ($fourth_level as $key => $fourth) {
                                            $html.="<li>";
                                            if ($third->left_id == $fourth->id) {
                                                if(!empty($fourth->id)){
                                                    $level_checking = $this->levelCheck($fourth->user_id);
                                                    $fourth_level_node = Tree::where('user_id', $fourth->user_id)->first();
                                                    $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($fourth->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$fourth_level_node->member->name.'<br> ('.$level_checking.')
                                                        <div class="info">
                                                            <h5>Name : '.$fourth_level_node->member->name.'</h5>
                                                            <h5>Sponsor ID : '.$fourth_level_node->member->login_id.'</h5>
                                                            <h5>Level : '.$level_checking.'</h5>
                                                        </div>  
                                                    </a>';
                                                }
                                            } else if($third->right_id == $fourth->id){
                                                if(!empty($fourth->id)){
                                                    $level_checking = $this->levelCheck($fourth->user_id);
                                                    $fourth_level_node = Tree::where('user_id', $fourth->user_id)->first();
                                                    $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($fourth->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$fourth_level_node->member->name.'<br> ('.$level_checking.')
                                                    <div class="info">
                                                        <h5>Name : '.$fourth_level_node->member->name.'</h5>
                                                        <h5>Sponsor ID : '.$fourth_level_node->member->login_id.'</h5>
                                                        <h5>Level : '.$level_checking.'</h5>
                                                    </div>  
                                                </a>';
                                                }
                                            }

                                            // FIFTH LEVEL STARTS
                                            $fifth_level = Tree::where('parent_id',$fourth->id)->orderBy('parent_leg', 'ASC')->get();
                                            if ($fifth_level) {
                                                $html.="<ul>";
                                                if(empty($fourth->left_id)){
                                                    $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                                                }
                                                foreach ($fifth_level as $key => $fifth) {
                                                    $html.="<li>";
                                                    if ($fourth->left_id == $fifth->id) {
                                                        if(!empty($fifth->id)){
                                                            $level_checking = $this->levelCheck($fourth->user_id);
                                                            $fifth_level_node = Tree::where('user_id', $fifth->user_id)->first();
                                                            $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($fifth->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$fifth_level_node->member->name.'<br> ('.$level_checking.')
                                                            <div class="info">
                                                            <h5>Name : '.$fifth_level_node->member->name.'</h5>
                                                            <h5>Sponsor ID : '.$fifth_level_node->member->login_id.'</h5>
                                                            <h5>Level : '.$level_checking.'</h5>
                                                            </div>  
                                                            </a>';
                                                        }
                                                    } 
                                                   
                                                     if($fourth->right_id == $fifth->id){
                                                         if(!empty($fourth->right_id)  && !empty($fifth->id)){
                                                            $level_checking = $this->levelCheck($fourth->user_id);
                                                            $fifth_level_node = Tree::where('user_id', $fifth->user_id)->first();
                                                            $html.='<a  href="'.route('admin.member.tree', ['rank' => 0,'user_id' => encrypt($fifth->user_id)]).'"><img src="'.asset('admin/build/images/avatar.jpg').'">'.$fifth_level_node->member->name.'<br> ('.$level_checking.')
                                                            <div class="info">
                                                            <h5>Name : '.$fifth_level_node->member->name.'</h5>
                                                            <h5>Sponsor ID : '.$fifth_level_node->member->login_id.'</h5>
                                                            <h5>Level : '.$level_checking.'</h5>
                                                            </div>  
                                                            </a>';
                                                        }
                                                    }
                                                }
                                                if(empty($fourth->right_id)){
                                                    $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                                                }
                                                $html.="</ul>";
                                            }
                                            $html.="</li>";
                                            $count++;
                                        }
                                        if(empty($third->right_id)){
                                            $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                                        }
                                        $html.="</ul>";
                                    }
                                    $html.="</li>";
                                }
                                if(empty($second->right_id)){
                                    $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                                }
                                
                                $html.="</ul>";
                                /////THIRD LEVEL ENDS
                            }

                            $html.="</li>";
                        }
                        if(empty($first->right_id)){
                            $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                        }
                        $html.="</ul>";
                    }
                    /////////////////////Second End
                    $html.="</li>";
                }
                if(empty($root->right_id)){
                    $html.='<li><a href="#"><img src="'.asset('admin/build/images/none-avatar.jpg').'">Empty</a></li>';
                }
                $html.="</ul>";
            }

            $html.="
                </li>
            </ul>";
        }      
       
        return view('admin.members.tree',compact('html'));
    }
    public function changeMemberPassword($id){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $member = Member::find($id);
        return view('admin.members.change_password', compact('member'));
    }
    public function updateMemberPassword(Request $request){
        $this->validate($request, [
            'password'   => 'required|min:6|required_with:confirm-password|same:confirm-password',
            'confirm-password' => 'min:6'
        ]);

        $member = Member::where('id', $request->input('id'))
                ->update(array('password' => Hash::make($request->input('password'))));
        if($member){
            return redirect()->back()->with('message','Password Changed'); 
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function memberStatus($id, $status){
        try {
            $id = decrypt($id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
   
        $status_member = DB::table('members')
            ->where('id', $id)
            ->update([
                'status' => $status,
                'updated_at' => Carbon::now()
            ]);

        if($status_member){
            return redirect()->back()->with('message', 'Activated Successfully!');
        }else{
            return redirect()->back()->with('message', 'Deactivated Successfully');
        }
   
    }
    // Manual Functions
    private function levelCheck($id){
        $total_pair = Tree::where('user_id', $id)->value('total_pair');
        if($total_pair >= 24 && $total_pair <= 50){
            return "SILVER";
        }elseif ($total_pair >=50 && $total_pair <=200) {
            return "GOLD";
        }elseif ($total_pair >=200 && $total_pair <=500) {
            return "PEARL";
        }elseif ($total_pair >=500 && $total_pair <=1000) {
            return "RUBY";
        }elseif ($total_pair >=1000 && $total_pair <=1500) {
            return "EMERALD";
        }elseif ($total_pair >=1500 && $total_pair <=2500) {
            return "DIAMOND";
        }elseif ($total_pair >=2500 && $total_pair <=5000) {
            return "DOUBLE DIAMOND";
        }elseif ($total_pair >=5000 && $total_pair <=10000) {
            return "TRIPLE DIAMOND";
        }elseif ($total_pair >=10000 && $total_pair <=25000) {
            return  "CROWN LEADER";
        }elseif ($total_pair >=25000 && $total_pair <=50000) {
            return "CROWN AMBESSADOR";
        }else{
            return "FRESHER";
        }
    }
}
