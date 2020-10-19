<?php

namespace App\Http\Controllers\Member\Registration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Tree;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Wallet;
use Auth;
use App\Models\TempMember;
use Carbon\Carbon;
use DB;
use App\Models\WalletHistory;
use App\Models\Order;
use Hash;
use App\Models\PairTiming;
use App\Models\MemberPairTiming;
use App\Models\AdminWallet;
use App\Models\AdminWalletHistory;
use App\Models\CommissionHistory;
use App\Models\Commission;
class RegistrationController extends Controller
{
    public function index(){
        return view('member.register.index');
    }

    public function store(Request $request){
        $wallet = Wallet::where('user_id', Auth::guard('member')->user()->id)->first();
        if(($wallet->amount >= 1499) && !empty($wallet->amount)){
            $this->validate($request, [
                'search_sponsor_id'     => 'required',
                'f_name'                => 'required',
                'l_name'                => 'required',
                'leg'                   => 'required',
                'email'                 => 'required|email|unique:members',
                'mobile'                => 'required|regex:/[0-9]{9}/|unique:members',
                'gender'                => 'required',
                'state'                 => 'required',
                'city'                  => 'required',
                'pin'                   => 'required',
                'login_id'              => 'required|string|min:3|unique:members',
                'password'              => 'required|min:6|string|same:password_confirmation'
            ]);
            $sponsorID          = $request->input('search_sponsor_id');
            $leg                = $request->input('leg');
            $f_name             = $request->input('f_name');
            $m_name             = $request->input('m_name');
            $l_name             = $request->input('l_name');
            $fullName           = $f_name . " " . $m_name ." ". $l_name;
            $email              = $request->input('email');
            $mobile             = $request->input('mobile');
            $gender             = $request->input('gender');
            $dob                = $request->input('dob');
            $state              = $request->input('state');
            $city               = $request->input('city');
            $pin                = $request->input('pin');
            $login_id           = $request->get('login_id');
            $password           = $request->get('password');
    
            $member_data = Member::where('sponsor_id', $sponsorID)->first();
            if($member_data) {
                $tree_data = Tree::where('user_id', $member_data->id)->first();
                if($tree_data){
                    if ($leg == 1) {
                        if ($tree_data->left_id != "0") {
                            return redirect()->back()->with('error','Left Leg is already reserved!');
                        }
                    } else {
                        if ($tree_data->right_id != "0") {
                            return redirect()->back()->with('error','Right leg is already reserved!');
                        }
                    }

                    $temp_members = new TempMember;
                    $temp_members->name          = $fullName;
                    $temp_members->email         = $email;
                    $temp_members->mobile        = $mobile;
                    $temp_members->gender        = $gender;
                    $temp_members->dob           = $dob;
                    $temp_members->leg           = $leg;
                    $temp_members->state         = $state;
                    $temp_members->city          = $city;
                    $temp_members->pin           = $pin;
                    $temp_members->login_id      = $login_id;
                    $temp_members->registered_by = $sponsorID;
                    $temp_members->password      = Hash::make($password);
                    if($temp_members->save()) {
                        return redirect()->route('member.product_page',['id'=>encrypt($temp_members->id)]);
                    }
                }else{
                    return redirect()->back()->with('error','Woops! Tree ai\'n\t there!');
                }
            }else{
                return redirect()->back()->with('error','Invalid Sponsor ID');
            }
        }else {
            return redirect()->back()->with('error','Insufficient Wallet Balance to Register a member!');
        }
    }

    public function searchSponsorID(Request $request){
        if($request->ajax()){
            $sponsorID = $request->get('query');
            if(!empty($sponsorID)) {
                $member_data = Member::where('sponsor_id', $sponsorID)->first();
                if($member_data) {
                    $tree_data = Tree::where('user_id', $member_data->id)->first();
                    if($tree_data){
                        if(($tree_data->left_id == "0") && ($tree_data->right_id == "0")){
                            $html = '
                            <label>
                                <font color="green">Yay! Both lags are empty</font>
                            </label><br>
                            <label for="gender"> Name</label>
                            <input type="text" value="'.$member_data->name.'" class="form-control" readonly placeholder="Name">
                            <label for="gender">Mobile</label>
                            <input type="text" value="'.$member_data->mobile.'" class="form-control" readonly placeholder="Mobile">
                            <label for="gender">DOB</label>
                            <input type="text" value="'.$member_data->dob.'" class="form-control" readonly placeholder="DOB"><br>
                            <label class="control-label ">Select Lag*</label>
                              <div id="lag">
                                  <input type="radio" name="leg" value="1" id="left_lag" checked> Left &nbsp;
                                  <input type="radio" name="leg" value="2" id="right_lag"> Right
                              </div>';
                            echo $html;
                        }
                        else if($tree_data->left_id == "0"){
                            $html = '
                            <label>
                                <font color="green">Left lag is empty!</font>
                            </label><br>
                            <label for="gender"> Name</label>
                            <input type="text" value="'.$member_data->name.'" class="form-control" readonly placeholder="Name">
                            <label for="gender">Mobile</label>
                            <input type="text" value="'.$member_data->mobile.'" class="form-control" readonly placeholder="Mobile">
                            <label for="gender">DOB</label>
                            <input type="text" value="'.$member_data->dob.'" class="form-control" readonly placeholder="DOB"><br>
                            <label class="control-label ">Select Lag*</label>
                              <div id="lag">
                                  <input type="radio" name="leg" value="1" id="left_lag" checked> Left &nbsp;
                                  <input type="radio" name="leg" value="2" id="right_lag" disabled> Right
                              </div>';
                            return $html;
                        }
                        else if($tree_data->right_id == "0"){
                            $html = '
                            <label>
                                <font color="green">Right lag is empty!</font>
                            </label><br>
                            <label for="gender"> Name</label>
                            <input type="text" value="'.$member_data->name.'" class="form-control" readonly placeholder="Name">
                            <label for="gender">Mobile</label>
                            <input type="text" value="'.$member_data->mobile.'" class="form-control" readonly placeholder="Mobile">
                            <label for="gender">DOB</label>
                            <input type="text" value="'.$member_data->dob.'" class="form-control" readonly placeholder="DOB"><br>
                            <label class="control-label ">Select Lag*</label>
                              <div id="lag">
                                  <input type="radio" name="leg" value="1" id="left_lag" disabled> Left &nbsp;
                                  <input type="radio" name="leg" value="2" id="right_lag" checked> Right
                              </div>';
                            return $html;
                        }else{
                            return 5;
                        }
                    }else{
                        return 1;
                    }

                }else{
                    return 1;
                }
            }else {
                return 1;
            }
        }else{
            return 9;
        }
    }

    public function loginIDCheck(Request $request)
    {
        if($request->ajax()){
            $login_id = $request->get('query');
            if(!empty($login_id)) {
                $member_data = Member::where('login_id', $login_id)->count();
                if($member_data > 0){
                    echo 1;
                }else{
                    echo 2;
                }
            }
        }
    }

    public function productPage($id){
        try{
            $id = decrypt($id);
        }catch(DecryptException $e) {
            abort(404);
        }
        $temp_member = TempMember::find($id);
        if ($id == $temp_member->id) {
            $products = Product::orderBy('created_at', 'DESC')->limit(1)->get();
            return view('member.register.product', compact('products', 'temp_member'));
        } else {
            abort(404);
        }
    }

    public function purchasePage(Request $request){
        $this->validate($request, [
            'product_id' => 'required'
        ]);

        $id = $request->input('id');
        $product_id = $request->input('product_id');
        $user_id = Auth::guard('member')->user()->id;
        $temp_member = TempMember::find($id);
        $temp_id = null;
        $wallet = Wallet::where('user_id', $user_id)->first();
        if($wallet->amount >= 1499){
            try {
                DB::transaction(function () use ($wallet, $user_id, $product_id, $temp_member, &$temp_id) {
                    $temp_id = $temp_member->id;
                    // Wallet Table Update
                    $wallet->amount = ($wallet->amount - 1499);
                    $wallet->save();

                    // Wallet History table Insert
                    $wallet_history                     = new WalletHistory;
                    $wallet_history->wallet_id          = $wallet->id;
                    $wallet_history->user_id            = $user_id;
                    $wallet_history->transaction_type   = "2";
                    $wallet_history->amount             = "1499";
                    $wallet_history->total_amount       = $wallet->amount;
                    $wallet_history->comment            = "Rs 1499.00 is debited from your wallet for the registration of sponsor ID ".$temp_member->sponsor_id;
                    $wallet_history->save();
                    
                    // Member Table Insert
                    $member = new Member;
                    $member->login_id       = $temp_member->login_id;
                    $member->name           = $temp_member->name;
                    $member->email          = $temp_member->email;
                    $member->password       = $temp_member->password;
                    $member->leg            = $temp_member->leg;
                    $member->mobile         = $temp_member->mobile;
                    $member->gender         = $temp_member->gender;
                    $member->dob            = $temp_member->dob;
                    $member->state          = $temp_member->state;
                    $member->city           = $temp_member->city;
                    $member->pin            = $temp_member->pin;
                    $member->registered_by  = $temp_member->registered_by;
                    $member->save();

                    // Sponosor ID Generate
                    $generatedID        = $this->generateSponsorID($temp_member->name, $member->id);
                    $member->sponsor_id = $generatedID;
                    $member->save();

                    $fetch_member = Member::where('sponsor_id', $member->registered_by)->first();
                    $tree = Tree::where('user_id', $fetch_member->id)->first();

                    // Tree Insert
                    $tree_insert                   = new Tree;
                    $tree_insert->user_id          = $member->id;
                    $tree_insert->parent_id        = $tree->id;
                    $tree_insert->registered_by    = $user_id;
                    $tree_insert->created_at       = Carbon::now();
                    $tree_insert->save();

                    $parent_update = $this->treeUpdate($tree_insert, $member->leg, $tree);
                    if($parent_update == 2){
                        throw new Exception();
                    }

                    // Wallet Creation
                    $wallet_insert          = new Wallet;
                    $wallet_insert->user_id = $member->id;
                    $wallet_insert->save();

                    // Order Table insert
                    $order                  = new Order;
                    $order->user_id         = $member->id;
                    $order->product_id      = $product_id;
                    $order->amount          = $wallet_history->amount;
                    $order->save();

                    
                    // Delete the data from temp table
                    $delete_temp = TempMember::where('created_at','<',Carbon::now())->delete();

                    // Tree Insert(Brain of MLM)
                    $parrents = DB::select( DB::raw("SELECT * FROM (
                        SELECT @pv:=(
                            SELECT parent_id FROM tree WHERE id = @pv
                            ) AS lv FROM tree
                            JOIN
                            (SELECT @pv:=:start_node) tmp
                        ) a
                        WHERE lv IS NOT NULL AND lv != 0 LIMIT 1000")
                        , array(
                          'start_node' => $tree_insert->id,
                        )
                    );
                    $a = $this->treePair($parrents, $tree_insert->id);
                });
                if($id == $temp_id){
                    return redirect()->route('member.finish');
                }else {
                    abort(404);
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Something went wrong!');
            } 
        }else {
            return redirect()->back()->with('error','Sorry! Insufficient Balance!');
        }
    }

    public function finishPage(){
        $msg = "Registration Successfull";
        return view('member.register.finish', compact('msg'));
    }

    // Manual Functions
    private function generateSponsorID($fullName, $id){
        $splitName = explode(' ', trim($fullName), 3); 
        $first_name = trim($splitName[0]);
        $last_name = trim($splitName[2]);
        $title_id = $first_name[0].$last_name[0];
        $l_id = 6 - strlen((string)$id);
        $generatedID = $title_id ;
        for ($i=0; $i < $l_id; $i++) { 
            $generatedID .= "0";
        }
        $generatedID .= $id;
        return $generatedID;
    }

    private function treePair($parents, $inserted_tree_id){
        $child = $inserted_tree_id;
        for($i=0; $i < count($parents) ; $i++) {
            $parent = $parents[$i]->lv; 
            $fetch_parent = Tree::find($parent);
            if ($fetch_parent->left_id == $child){
                $fetch_parent->left_count =  $fetch_parent->left_count + 1;
                $fetch_parent->total_left_count =  $fetch_parent->total_left_count + 1;
                $fetch_parent->save();
            }else if($fetch_parent->right_id == $child){
                $fetch_parent->right_count =  $fetch_parent->right_count + 1;
                $fetch_parent->total_right_count =  $fetch_parent->total_right_count + 1;
                $fetch_parent->save();
            }   

            //Check 1:1 Check
            if($fetch_parent->right_count > 0 && $fetch_parent->left_count  > 0){
                $this->creditCommisionOneIsToOne($fetch_parent, $parent);
                $fetch_parent->total_pair = ($fetch_parent->total_pair + 1);
                $fetch_parent->save();
            }
            $child = $parent;
        }
    }

    private function creditCommisionOneIsToOne($tree, $parent){
        $timing = $this->checkTimeFrameDuplication($parent);
        if($timing){
            $this->commissionCredit($tree, $parent, $status = '1');
        }else {
            $this->commissionCredit($tree, $parent, $status = '2');
        }

        $commission = Commission::first();

    }
    private function checkTimeFrameDuplication($parent){
        $current_time = Carbon::now()->setTimezone('Asia/Kolkata')->toTimeString();
        $pair_timings = PairTiming::where('from','<=',$current_time)->where('to','>=',$current_time)->first();
        $current_date = Carbon::now()->setTimezone('Asia/Kolkata')->toDateString();
        $time_frame_from = $current_date." ".$pair_timings->from;
        $time_frame_to = $current_date." ".$pair_timings->to;
        $member_pair_timings = MemberPairTiming::where('user_id', $parent)->whereBetween('created_at', [$time_frame_from, $time_frame_to])->count();
        if($member_pair_timings > 2 ){
            return true;
        }else {
            return false;
        }
    }

    private function commissionCredit($tree, $parent, $status){
        $commission = Commission::first();
        $wallet = Wallet::where('user_id', $tree->user_id)->first();

        $tree->left_count   = ($tree->left_count - 1);
        $tree->right_count  = ($tree->right_count - 1);
        $tree->save();

        if($status == 1){
            $credit_commision               = new CommissionHistory;
            $credit_commision->user_id      = $tree->user_id;
            $credit_commision->pair_number  = ($tree->total_pair + 1);
            $credit_commision->comment      = 'Pair number '.($tree->total_pair + 1).' is on Duplicate TimeFrame Capping!';
            $credit_commision->status       = 2;
            $credit_commision->created_at   = Carbon::now();
            $credit_commision->save();

        }else {
            $member_pair_timings = new MemberPairTiming;
            $member_pair_timings->user_id = $parent;
            $member_pair_timings->save();

            // Admin Commission = 10%
            $admin_wallet           = AdminWallet::first();
            $admin_charge           = ($commission->commission * 10)/100;
            $admin_wallet->amount   = ($admin_wallet->amount + $admin_charge);
            $admin_wallet->save();

            // Admin History
            $admin_wallet_history                   = new AdminWalletHistory;
            $admin_wallet_history->amount           = $admin_charge;
            $admin_wallet_history->total_amount     = $admin_wallet->amount;
            $admin_wallet_history->comment          = 'Rs '.$admin_charge.' is successfully credited for new registration';
            $admin_wallet_history->transaction_type = 1;
            $admin_wallet_history->created_at       = Carbon::now();
            $admin_wallet_history->save();

            $earning = (499 - $admin_charge);

            // Credit to Wallet
            $wallet->amount = ($wallet->amount + $earning);
            $wallet->save();

            // Credit to Commission History
            $credit_commision               = new CommissionHistory;
            $credit_commision->user_id      = $tree->user_id;
            $credit_commision->pair_number  = ($tree->total_pair + 1);
            $credit_commision->amount       = $earning;
            $credit_commision->comment      = $earning.' income of pair number '.($tree->total_pair+1).' is generated! ';
            $credit_commision->status       = 1;
            $credit_commision->created_at   = Carbon::now();
            $credit_commision->save();

            // Credit Wallet History
            $credit_to_wallet                       = new WalletHistory;
            $credit_to_wallet->wallet_id            = $wallet->id;
            $credit_to_wallet->user_id              = $tree->user_id;
            $credit_to_wallet->transaction_type     = 1;
            $credit_to_wallet->amount               = $earning;
            $credit_to_wallet->total_amount         = $wallet->amount;
            $credit_to_wallet->comment              = $earning.' income of pair number'.($tree->total_pair+1).' is generated!';
            $credit_to_wallet->created_at           = Carbon::now();
            $credit_to_wallet->save();
        }
    }

    private function treeUpdate($tree_insert, $leg, $parent_tree){
        if ($leg == 1) {
            if ($parent_tree->left_id == '0') {
                $parent_tree->left_id       = $tree_insert->id;
                $parent_tree->updated_at    = Carbon::now();
                $parent_tree->save();
                return 1;
            } else {
                return 2;
            }
            
        }else {
            if ($parent_tree->right_id == '0') {
                $parent_tree->right_id      = $tree_insert->id;
                $parent_tree->updated_at    = Carbon::now();
                $parent_tree->save();
                return 1;
            } else {
                return 2;
            }
            
        }
    }
}
