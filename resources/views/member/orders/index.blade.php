@extends('member.template.admin_master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12" style="margin-top:50px;">
            <div class="x_panel">
                <div class="x_title">
                    <h2>My Order</h2>
                    <div class="clearfix"></div>
                </div>
                @if (Session::has('message'))
                    <div class="alert alert-success" >{{ Session::get('message') }}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                <div class="x_content">
                    <table id="order_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>Product Name</th>
                            <th>Photo</th>
                            <th>Amount</th>
                            <th>Reistered At</th>
                        </tr>
                        </thead>
                        <tbody>                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            var i = 1;
            var table = $('#order_list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 50,
                ajax: "{{ route('member.ajax.orders') }}",
                columns: [
                    { "render": function(data, type, full, meta) {return i++;}},
                    {data: 'product', name: 'product',searchable: true},
                    {data: 'product_image', name: 'product_image' ,searchable: true}, 
                    {data: 'amount', name: 'amount' ,searchable: true}, 
                    {data: 'created_at', name: 'created_at' ,searchable: true},                 
                ]
            });
        });
    </script>
@endsection