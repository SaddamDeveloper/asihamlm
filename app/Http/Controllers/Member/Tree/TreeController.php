<?php

namespace App\Http\Controllers\Member\Tree;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
class TreeController extends Controller
{
    public function memberTree($rank=null, $user_id=null){
        
        if (!empty($user_id)) {
            try{
                $user_id = decrypt($user_id);
            }catch(DecryptException $e) {
                abort(404);
            }
        }else{
            $user_id = Auth::guard('member')->user()->id;
        }
        if (empty($rank)) {
            $rank = 0;
        }

        $html=null;
        $root = DB::table('tree')
            ->select('tree.*', 'members.name', 'members.sponsor_id')
            ->join('members', 'tree.user_id', '=', 'members.id')
            ->where('user_id', $user_id)
            ->first();
        if($root){
            $html = '<ul>
            <li>        
                <a href="#">'.$root->name.'
                    <div class="info">
                        <h5>Name : '.$root->name.'</h5>
                        <h5>Id : '.$root->sponsor_id.'</h5>
                        <h5>Rank : '.$rank.'</h5>
                    </div>
                </a>';
            $rank++;
            $first_level = DB::table('tree')->where('parent_id',$root->id)->get();
            if ($first_level) {
                $html.="<ul>";
                if(empty($root->left_id)){
                    $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                }
                foreach ($first_level as $key => $first) {
                    $html.="<li>";
                    if ($root->left_id == $first->id) {
                        $first_level_node = DB::table('tree')
                        ->select('tree.*', 'members.name', 'members.sponsor_id')
                        ->join('members', 'tree.user_id', '=', 'members.id')
                        ->where('tree.user_id', $first->id)
                        ->first();
                        $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($first->user_id)]).'">'.$first_level_node->name.'
                            <div class="info">
                                <h5>Name : '.$first_level_node->name.'</h5>
                                <h5>Id : '.$first_level_node->sponsor_id.'</h5>
                                <h5>Rank : '.$rank.'</h5>
                            </div>  
                        </a>';
                    } else if($root->right_id == $first->id){
                        $first_level_node = DB::table('tree')
                        ->select('tree.*', 'members.name', 'members.sponsor_id')
                        ->join('members', 'tree.user_id', '=', 'members.id')
                        ->where('tree.user_id', $first->id)
                        ->first();
                        $html.='<a href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($first->user_id)]).'">'.$first_level_node->name.'
                            <div class="info">
                                <h5>Name : '.$first_level_node->name.'</h5>
                                <h5>Id : '.$first_level_node->sponsor_id.'</h5>
                                <h5>Rank : '.$rank.'</h5>
                            </div>  
                        </a>';
                    }

                    $second_level = DB::table('tree')->where('parent_id',$first->id)->orderBy('parent_leg', 'ASC')->get();


                    if ($second_level) {
                        $html.="<ul>";
                        if(empty($first->left_id)){
                            $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                        }
                        foreach ($second_level as $key => $second) {
                            $html.="<li>";
                            if ($first->left_id == $second->id) {
                                $second_level_node = DB::table('tree')
                                ->select('tree.*', 'members.name', 'members.sponsor_id')
                                ->join('members', 'tree.user_id', '=', 'members.id')
                                ->where('tree.user_id', $second->id)
                                ->first();
                                $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($second->user_id)]).'">'.$second_level_node->name.'
                                            <div class="info">
                                                <h5>Name : '.$second_level_node->name.'</h5>
                                                <h5>Id : '.$second_level_node->sponsor_id.'</h5>
                                                <h5>Rank : '.$rank.'</h5>
                                            </div>  
                                        </a>';
                            } else if($first->right_id == $second->id){
                                $second_level_node = DB::table('tree')
                                ->select('tree.*', 'members.name', 'members.sponsor_id')
                                ->join('members', 'tree.user_id', '=', 'members.id')
                                ->where('tree.user_id', $second->id)
                                ->first();
                                $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($second->user_id)]).'">'.$second_level_node->name.'
                                    <div class="info">
                                        <h5>Name : '.$second_level_node->name.'</h5>
                                        <h5>Id : '.$second_level_node->sponsor_id.'</h5>
                                        <h5>Rank : '.$rank.'</h5>
                                    </div>  
                                </a>';
                            }

                            //THIRD LEVEL STARTS
                            $third_level = DB::table('tree')->where('parent_id',$second->id)->orderBy('parent_leg', 'ASC')->get();

                           
                            
                            if ($third_level) {
                                $html.="<ul>";
                                if(empty($second->left_id)){
                                    $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                                }
                                foreach ($third_level as $key => $third) {
                                    $html.="<li>";
                                    if ($second->left_id == $third->id) {
                                        $third_level_node = DB::table('tree')
                                        ->select('tree.*', 'members.name', 'members.sponsor_id')
                                        ->join('members', 'tree.user_id', '=', 'members.id')
                                        ->where('tree.user_id', $third->id)
                                        ->first();
                                        $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($third->user_id)]).'">'.$third_level_node->name.'
                                            <div class="info">
                                                <h5>Name : '.$third_level_node->name.'</h5>
                                                <h5>Id : '.$third_level_node->sponsor_id.'</h5>
                                                <h5>Rank : '.$rank.'</h5>
                                            </div>  
                                        </a>';
                                    } else if($second->right_id == $third->id){
                                        $third_level_node = DB::table('tree')
                                        ->select('tree.*', 'members.name', 'members.sponsor_id')
                                        ->join('members', 'tree.user_id', '=', 'members.id')
                                        ->where('tree.user_id', $third->id)
                                        ->first();
                                        $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($third->user_id)]).'">'.$third_level_node->name.'
                                            <div class="info">
                                                <h5>Name : '.$third_level_node->name.'</h5>
                                                <h5>Id : '.$third_level_node->sponsor_id.'</h5>
                                                <h5>Rank : '.$rank.'</h5>
                                            </div>  
                                        </a>';
                                    }
                                    //FOURTH LEVEL STARTS
                                    $fourth_level = DB::table('tree')->where('parent_id',$third->id)->orderBy('parent_leg', 'ASC')->get();
                                    if ($fourth_level) {
                                        $html.="<ul>";
                                        if(empty($third->left_id)){
                                            $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                                        }
                                        foreach ($fourth_level as $key => $fourth) {
                                            $html.="<li>";
                                            if ($third->left_id == $fourth->id) {
                                                $fourth_level_node = DB::table('tree')
                                                ->select('tree.*', 'members.name', 'members.sponsor_id')
                                                ->join('members', 'tree.user_id', '=', 'members.id')
                                                ->where('tree.user_id', $fourth->id)
                                                ->first();
                                                $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($fourth->user_id)]).'">'.$fourth_level_node->name.'
                                                    <div class="info">
                                                        <h5>Name : '.$fourth_level_node->name.'</h5>
                                                        <h5>Id : '.$fourth_level_node->sponsor_id.'</h5>
                                                        <h5>Rank : '.$rank.'</h5>
                                                    </div>  
                                                </a>';
                                            } else if($third->right_id == $fourth->id){
                                                $fourth_level_node = DB::table('tree')
                                                ->select('tree.*', 'members.name', 'members.sponsor_id')
                                                ->join('members', 'tree.user_id', '=', 'members.id')
                                                ->where('tree.user_id', $fourth->id)
                                                ->first();
                                                $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($fourth->user_id)]).'">'.$fourth_level_node->name.'
                                                <div class="info">
                                                    <h5>Name : '.$fourth_level_node->name.'</h5>
                                                    <h5>Id : '.$fourth_level_node->sponsor_id.'</h5>
                                                    <h5>Rank : '.$rank.'</h5>
                                                </div>  
                                            </a>';
                                            }

                                            // FIFTH LEVEL STARTS
                                            $fifth_level = DB::table('tree')->where('parent_id',$fourth->id)->orderBy('parent_leg', 'ASC')->get();
                                            if ($fifth_level) {
                                                $html.="<ul>";
                                                if(empty($fourth->left_id)){
                                                    $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                                                }
                                                foreach ($fifth_level as $key => $fifth) {
                                                    $html.="<li>";
                                                    if ($fourth->left_id == $fifth->id) {
                                                        $fifth_level_node = DB::table('tree')
                                                        ->select('tree.*', 'members.name', 'members.sponsor_id')
                                                        ->join('members', 'tree.user_id', '=', 'members.id')
                                                        ->where('tree.user_id', $fifth->id)
                                                        ->first();
                                                        $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($fifth->user_id)]).'">'.$fifth_level_node->name.'
                                                            <div class="info">
                                                                <h5>Name : '.$fifth_level_node->name.'</h5>
                                                                <h5>Id : '.$fifth_level_node->sponsor_id.'</h5>
                                                                <h5>Rank : '.$rank.'</h5>
                                                            </div>  
                                                        </a>';
                                                    } else if($fourth->right_id == $fifth->id){
                                                        $fifth_level_node = DB::table('tree')
                                                        ->select('tree.*', 'members.name', 'members.sponsor_id')
                                                        ->join('members', 'tree.user_id', '=', 'members.id')
                                                        ->where('tree.user_id', $fifth->id)
                                                        ->first();
                                                        $html.='<a  href="'.route('member.tree', ['rank' => 0,'user_id' => encrypt($fifth->user_id)]).'">'.$fifth_level_node->name.'
                                                        <div class="info">
                                                            <h5>Name : '.$fifth_level_node->name.'</h5>
                                                            <h5>Id : '.$fifth_level_node->sponsor_id.'</h5>
                                                            <h5>Rank : '.$rank.'</h5>
                                                        </div>  
                                                    </a>';
                                                    }
                                                }
                                                if(empty($fourth->right_id)){
                                                    $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                                                }
                                                $html.="</ul>";
                                            }
                                            $html.="</li>";
                                        }
                                        if(empty($third->right_id)){
                                            $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                                        }
                                        $html.="</ul>";
                                    }
                                    $html.="</li>";
                                }
                                if(empty($second->right_id)){
                                    $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                                }
                                
                                $html.="</ul>";
                                /////THIRD LEVEL ENDS
                            }

                            $html.="</li>";
                        }
                        if(empty($first->right_id)){
                            $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                        }
                        $html.="</ul>";
                    }
                    /////////////////////Second End
                    $html.="</li>";
                }
                if(empty($root->right_id)){
                    $html.='<li><a href="#" style="background-color: grey; color: white;">Empty</a></li>';
                }
                $html.="</ul>";
            }

            $html.="
                </li>
            </ul>";
        }     
        return view('member.tree.index', compact('html'));
    }
}
