@extends('member.template.admin_master')

@section('css')
    <style>
        .productsction .producttitle h4{
            text-align: center;
            font-size: 20px;
            margin: 0;
            color: #000;
            font-weight: bold;
        }
        .productsction .producttitle p{
            text-align: center;
            font-size: 16px;
        }
        .productsction .productcontent img{
            width: 100%;
        }
        .productsction .productcontent h5{
            text-align: center;
            border: 1px solid red;
            padding: 5px 0;
        }
        .productsction .productcontent .singleproduct img.fstchld {
            border: 1px solid red;
            margin-bottom: 20px;
            height: 200px;
            width: 200px;
        }
        .bottomcontent h5{
            display: table;
            padding: 7px 65px!important;
            color: #333;
            margin: 20px auto 0;
            border: 0!important;
            font-size: 26px;
            background: linear-gradient(#aae8dd,#43c1ac);
        }

        /* HIDE RADIO */
        .singleproduct [type=radio] { 
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* IMAGE STYLES */
        .singleproduct [type=radio] ~ img {
            cursor: pointer;
        }
        
        /* CHECKED STYLES */
        .singleproduct [type=radio]:checked ~ img {
            outline: 2px solid #f00;
        }

    </style>
@endsection
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            {{-- <div class="col-md-2"></div> --}}
            <div class="col-md-12" style="margin-top:50px;">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Product</h2>
                        <div class="clearfix"></div>
                    </div>
                    @include('member.include.error')
                    <div class="x_content">
                        {{ Form::open(['method' => 'post','route'=>'member.purchase']) }}
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10 mb-2">
                                <div class="col-md-12 mx-auto col-sm-12 col-xs-12 mb-3">
                                    <div class="productsction">
                                        <div class="producttitle">
                                            <h4>{{__('Product for APM')}}</h4>
                                            <p>{{__('Start your business to buy any one package')}}</p>
                                        </div>
                                        @if (count($products) > 0)
                                            <div class="productcontent">
                                                <div class="row">
                                                    @foreach ($products as $product)
                                                    <div class="col-md-4 singleproduct">
                                                        <label>
                                                            <input type="radio" name="product_id" value="{{$product->id}}" checked>
                                                            <input type="hidden" name="id" value="{{ $temp_member->id }}">
                                                            <h5>{{$product->name}}</h5> 
                                                            <img src="{{asset('/product/thumb/'.$product->image)}}" name="image" alt="" class="fstchld">
                                                            <h5>
                                                                ₹ {{number_format($product->price, 2)}}
                                                            </h5>
                                                        </label>
                                                        @if ($errors->has('product'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('product') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                        <div class="productcontent">
                                            <div class="row">
                                                No Data Found
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Next', array('class'=>'btn btn-success pull-right')) }}  
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection


