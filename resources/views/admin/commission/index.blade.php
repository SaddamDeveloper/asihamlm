@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Commission</h2>
            <div class="clearfix"></div>
        </div>
        @if (Session::has('message'))
            <div class="alert alert-success" >{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="x_content">
            {{ Form::open(['method' => 'post','route'=>'admin.add_commission']) }}
               <div class="well" style="overflow: auto">
                   <div class="form-row mb-10">
                       <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                       <label for="name">Set Commission</label>
                       <input type="text" class="form-control" name="commission" value="{{ number_format($commission, 2) }}"  placeholder="Set Commission">
                           @if($errors->has('commission'))
                               <span class="invalid-feedback" role="alert" style="color:red">
                                   <strong>{{ $errors->first('commission') }}</strong>
                               </span>
                           @enderror
                       </div>                     
                   </div>
               </div>

               <div class="form-group">    	            	
                   {{ Form::submit('Submit', array('class'=>'btn btn-success pull-right')) }}  
                   </div>
                   {{ Form::close() }}
               </div>
           </div>
      </div>
    </div>
  </div>
</div>
 @endsection