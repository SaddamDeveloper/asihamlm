@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Orders</h2>
            <div class="clearfix"></div>
        </div>
        <div>
          <div class="x_content">
            <table id="order_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Sl. No</th>
                  <th>Name</th>
                  <th>Product</th>
                  {{-- <th>Photo</th> --}}
                  <th>Amount</th>
                  <th>Created At</th>
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
</div>
 @endsection
 @section('script')
    <script type="text/javascript">
        $(function () {
        var table = $('#order_list').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 50,
            ajax: "{{ route('admin.ajax.orders') }}",
            columns: [
                {data: 'id', name: 'id',searchable: true},
                {data: 'name', name: 'name',searchable: true},
                {data: 'product', name: 'product' ,searchable: true}, 
                // {data: 'product_image', name: 'product_image' ,searchable: true}, 
                {data: 'amount', name: 'amount' ,searchable: true}, 
                {data: 'created_at', name: 'created_at' ,searchable: true},                 
            ]
        });
        
    });
    </script>
@endsection