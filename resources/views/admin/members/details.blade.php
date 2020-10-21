@extends('admin.template.admin_master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
        <div class="row">
                {{-- <div class="col-md-2"></div> --}}
                <div class="col-md-12" style="margin-top:50px;">
                    <div class="x_panel">
    
                        <div class="x_title">
                            <h2>Member Details</h2>
                            <button class="btn btn-danger pull-right" onclick="javascript:window.close()"><i class="fa fa-close"></i></button>
                            <div class="clearfix"></div>
                        </div>
                    <div>
                         @if (Session::has('message'))
                            <div class="alert alert-success" >{{ Session::get('message') }}</div>
                         @endif
                         @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                         @endif
    
                    </div>
                        <div>
                            <div class="x_content">
                                <div class="x_content">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Sponsor ID</th>
                                            <td>{{$member->sponsor_id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Login ID</th>
                                            <td>{{$member->login_id}}</td>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <td>{{$member->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{$member->email}}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td>{{$member->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td>{{$member->dob}}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{{$member->status == 1 ? "ACTIVE" : "DEACTIVE"}}</td>
                                        </tr>
                                        @if (!empty($member->pan_card))
                                            <tr>
                                                <th>
                                                    PAN
                                                </th>
                                                <td>{{$member->pan_card}}</td>
                                            </tr>
                                        @endif
                                        @if (!empty($member->adhar_card))
                                        <tr>
                                            <th>Aadhar No</th>
                                            <td>{{$member->adhar_card}}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($member->address))
                                        <tr>
                                            <th>Address</th>
                                            <td>{{$member->address}}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($member->bank_name))
                                        <tr>
                                            <th>Bank Name</th>
                                            <td>{{$member->bank_name}}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($member->ac_holder_name))
                                        <tr>
                                            <th>Account Holder Name</th>
                                            <td>{{$member->ac_holder_name}}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($member->ifsc))
                                        <tr>
                                            <th>IFSC</th>
                                            <td>{{$member->ifsc}}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($member->account_no))
                                        <tr>
                                            <th>Account No</th>
                                            <td>{{$member->account_no}}</td>
                                        </tr>
                                        @endif
                                        @if (!empty($member->photo))
                                        <tr>
                                            <th>Photo</th>
                                            <td><img src="{{asset('images/'.$member->photo)}}" alt="" width="100"></td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-2"></div> --}}
        </div>
</div>
<!-- /page content -->
@endsection





