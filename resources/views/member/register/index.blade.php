@extends('member.template.admin_master')

@section('content')
@include('member.include.modal')
<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Registration</h2>
            <div class="clearfix"></div>
        </div>
        @if (Session::has('message'))
        <div class="alert alert-success" >{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div>
        <div class="x_content">
            {{ Form::open(['method' => 'post','route'=>'member.add_new_member']) }}
            <div class="well" style="overflow: auto">
                <div class="form-row mb-10 mb-2">
                    <div class="col-md-4 mx-auto col-sm-12 col-xs-12 mb-3">
                    </div>
                    <div class="col-md-4 mx-auto col-sm-12 col-xs-12 mb-3">
                        <label for="search_sponsor_id">Sponsor ID</label>
                        <input type="text" name="search_sponsor_id" id="search_sponsor_id" value="{{old('search_sponsor_id')}}" class="form-control" placeholder="Sponsor ID" required>
                        @if($errors->has('search_sponsor_id'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('search_sponsor_id') }}</strong>
                            </span>
                        @enderror
                        <div id="myDiv">
                            <img id="loading-image" src="{{asset('images/ajax-loader.gif')}}" style="display:none;"/>
                        </div>
                        <div id="member_data"></div><br>
                    </div> 
                    
                    <div class="col-md-4 mx-auto col-sm-12 col-xs-12 mb-3">
                        
                    </div>
                </div>
                <div class="form-row mb-10 mb-2">
                    <div class="col-md-4 mx-auto col-sm-12 col-xs-12 mb-3">
                        
                    </div>
                </div>
            </div>
            <div class="well" style="overflow: auto">
                <div class="form-row mb-3">
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="f_name">First Name*</label>
                        <input type="text" class="form-control" name="f_name" value="{{old('f_name')}}"  placeholder="Enter First Name" >
                        @if($errors->has('f_name'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('f_name') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="m_name">Middle Name</label>
                        <input type="text" class="form-control" name="m_name" value="{{old('m_name')}}"  placeholder="Enter Middle Name" >
                        @if($errors->has('m_name'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('m_name') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="l_name">Last Name*</label>
                        <input type="text" class="form-control" name="l_name" value="{{old('l_name')}}" placeholder="Enter Last Name" >
                        @if($errors->has('l_name'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('l_name') }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" name="email" value="{{old('email')}}"  placeholder="Enter Email" >
                        @if($errors->has('email'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="mobile">Mobile*</label>
                        <input type="text" class="form-control" name="mobile" value="{{old('mobile')}}" placeholder="Enter Mobile No" >
                        @if($errors->has('mobile'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('mobile') }}</strong>
                            </span>
                        @enderror
                    </div> 
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="gender">Gender*</label>
                        <select class="form-control" name="gender" id="gender">
                            <option value="" selected disabled>--Select Gender--</option>
                            <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Male</option>
                            <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>Female</option>
                        </select>
                        @if($errors->has('gender'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="dob">DOB</label>
                        <input type="date" name="dob" value="{{old('dob')}}" class="form-control"/>
                        @if($errors->has('dob'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('dob') }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="state">State*</label>
                        <input type="text" class="form-control" name="state" value="{{old('state')}}"  placeholder="Enter State">
                        @if($errors->has('state'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('state') }}</strong>
                            </span>
                        @enderror
                    </div> 
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="city">City*</label>
                        <input type="text" class="form-control" name="city" value="{{old('city')}}"  placeholder="Enter City">
                        @if($errors->has('city'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="city">Pin*</label>
                        <input type="text" class="form-control" name="pin" value="{{old('pin')}}" placeholder="Enter Pin No">
                        @if($errors->has('city'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="well" style="overflow: auto">
                <div class="form-row mb-3">
                    <h2>Login Credentials</h2>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="">Enter Login ID*</label>
                        <input type="text" class="form-control" name="login_id" id="login_id" value="{{old('login_id')}}" placeholder="Enter Login ID" required>
                        @if($errors->has('login_id'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('login_id') }}</strong>
                            </span>
                        @enderror
                        <button class="btn btn-success" id="check_login">Check Availability</button>
                        <img id="loading-image-login" src="{{asset('images/ajax-loader.gif')}}" style="display:none;"/>
                        <div id="login_name_show"></div><br>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="password">Password*</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        @if($errors->has('password'))
                            <span class="invalid-feedback" role="alert" style="color:red">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                        <label for="password">Confirm Password*</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        @if($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert" style="color:red">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="checkbox" id="test7" value="1" name="check" {{ old('check') == 1 ? 'checked' : '' }} required/>
                <label for="test7">Accept terms & conditions</label>    	            	
                {{ Form::submit('Next', array('class'=>'btn btn-success pull-right')) }}  
            </div>
            {{ Form::close() }}
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            function fetch_member_data(query){
                $.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });
                $.ajax({
                    url: "{{route('member.search_sponsor_id')}}",
                    method: "GET",
                    data: {query:query},
                    beforeSend: function() {
                        $("#loading-image").show();
                    },
                    success: function(data){
                        if(data == 5){
                            $('#member_data').html("<font color='red'>All legs are full! Try with another Sponsor ID</font>").fadeIn( "slow" );
                            $('#sponsorVal').val(data);
                            $("#loading-image").hide();
                        }else if(data == 1){
                            $('#member_data').html("<font color='red'>Invalid User ID!</font>").fadeIn( "slow" );
                            $("#loading-image").hide();
                            $('#sponsorVal').val(data);
                        }else{
                            $('#member_data').html(data);
                            $('#sponsorVal').val("200");
                            $("#loading-image").hide();
                        }
                    }
                });
            }
            $(document).on('blur', '#search_sponsor_id', function(){
                var query = $(this).val();
                if(query){
                    fetch_member_data(query);
                }
            });
            function check_login(query){
                $.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
                });
                $.ajax({
                    url: "{{route('member.login_id_check')}}",
                    method: "GET",
                    data: {query:query},
                    beforeSend: function() {
                        $("#loading-image-login").show();
                    },
                    success: function(data){
                        if(data == 1){
                            $('#login_name_show').html("<font color='red'>Sorry Username is already taken!</font>").fadeIn( "slow" );
                            $("#loading-image-login").hide();
                            $("#login_id")
                        }else{
                            $('#login_name_show').html("<font color='green'>Yay Username is available!</font>");
                            $("#loading-image-login").hide();
                        }
                    }
                });
            }
            $(document).on('blur', '#search_sponsor_id', function(e){
                e.preventDefault();
                var query = $(this).val();
                if(query){
                    fetch_member_data(query);
                }
            });
            $(document).on('blur', '.ac_name_check', function(){
                var fname = $('#f_name').val();
                var mname = $('#m_name').val();
                var lname = $('#l_name').val();
                var fullName = fname + " " + mname +" "+ lname;
                $("#ac_holder_name").val(fullName);
            });
            $(document).on('click', '#check_login', function(e){
                e.preventDefault();
                var query = $('#login_id').val();
                if(query){
                    check_login(query);
                }
            });
            $('input[type="checkbox"]').on('change', function(e){
                if(e.target.checked){
                    $('#myModal').modal();
                }
            });
        });

        /***
        * Display till today in DOB
        */
        var dtToday = new Date();
        var month = dtToday.getMonth() + 1;     // getMonth() is zero-based
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        $('#dob').attr('max', maxDate);
    </script>
@endsection