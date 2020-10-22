@extends('member.template.admin_master')

@section('content')
    <div class="right_col" role="main">
    <div class="row">

        <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Withdraw Request</h2>
                <h3 class="text-center">Wallet Balance: ₹ {{ number_format($wallet->amount, 2) }}</h3>
                <div class="clearfix"></div>
            </div>
            @if (Session::has('message'))
                <div class="alert alert-success" >{{ Session::get('message') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            <div class="x_content">
                {{ Form::open(['method' => 'post','route'=>'member.withdraw.amount']) }}
                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-10 mb-2 mx-auto">
                            <div class="col-sm-4 col-xs-12 mb-3">
                            </div>
                            <div class="col-sm-4 col-xs-12 mb-3">
                                <input type="number" class="form-control" name="amount" value="{{ old('amount') }}" placeholder="Enter Amount to withdraw">
                                @if($errors->has('amount'))
                                    <span class="invalid-feedback" role="alert" style="color:red">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::submit('Withdraw', array('class'=>'btn btn-success pull-right')) }}  
                    </div>
                {{ Form::close() }}
            </div>
        </div>
        </div>
    </div>
    </div>
@endsection