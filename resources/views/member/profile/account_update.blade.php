@extends('member.template.admin_master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
<div class="">
    <div class="clearfix"></div>
    @if (Session::has('message'))
        <div class="alert alert-success" >{{ Session::get('message') }}</div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_title">
            <h2>Account Update</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            {{ Form::open(['method' => 'post','route'=>'member.update_member', 'enctype'=>'multipart/form-data']) }}
            <div class="well" style="overflow: auto">
                <div class="form-row mb-10 mb-2">
                    <div class="col-md-6 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="member_id"> Member ID</label>
                        <input type="text" name="member_id" value="{{$member->login_id}}" class="form-control" disabled required>
                    </div>
                    <div class="col-md-6 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="member_name"> Member Name </label>
                        <input type="text" name="member_name" value="{{$member->name}}" class="form-control" required>
                    </div> 
                </div>
                <div class="form-row mb-10 mb-2">
                    <div class="col-md-6 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="mobile"> Mobile No </label>
                        <input type="text" name="mobile" value="{{$member->mobile}}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="email"> Email </label>
                        <input type="email" name="email" value="{{$member->email}}" class="form-control" required>
                        @if($errors->has('email'))
                        <span class="invalid-feedback" role="alert" style="color:red">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row mb-10 mb-2">
                    <div class="col-md-6 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="dob">DOB</label>
                        <input type="date" name="dob" value="{{$member->dob}}" class="form-control">
                        @if($errors->has('dob'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="pan">PAN*</label>
                        <input type="text" name="pan" id="pan" value="{{$member->pan_card}}" class="form-control">
                        @if($errors->has('pan'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('pan') }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row mb-10 mb-2">
                    <div class="col-md-6 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="aadhar">Aadhar</label>
                        <input type="text" name="aadhar" value="{{$member->adhar_card}}" class="form-control">
                        @if($errors->has('aadhar'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('aadhar') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control">{{$member->address}}</textarea>
                        @if($errors->has('address'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="bank">Bank Name</label>
                            <input type="text" class="form-control" name="bank" value="{{ $member->bank }}" placeholder="Enter Bank Name"> 
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="ac_holder_name">Account Holder Name</label>
                            <input type="text" name="ac_holder_name" id="ac_holder_name" value="" class="form-control" placeholder="Account Holder Name">
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="ifsc">IFSC</label>
                            <input type="text" name="ifsc" id="ifsc" value="{{$member->ifsc}}" class="form-control" placeholder="IFSC">
                            @if($errors->has('ifsc'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('ifsc') }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="account_no">Account No</label>
                            <input type="number" name="account_no" id="account_no" value="{{$member->account_no}}" class="form-control" placeholder="Accoount No">
                            @if($errors->has('account_no'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('account_no') }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" id="photo" value="" class="form-control">
                            @if($errors->has('photo'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('photo') }}</strong>
                            </span>
                            @enderror
                            <div>
                                <img src="{{$member->photo == NULL ? "" : asset('images/'.$member->photo) }}" width="100" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">    	            	
                {{ Form::submit('Update', array('class'=>'btn btn-success pull-right')) }}  
            </div>
            {{ Form::close() }}
        </div>
        </div>
    </div>
    </div>
</div>
</div>
<!-- /page content -->
@endsection


