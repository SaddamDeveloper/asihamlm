@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Products</h2>
            <a href="{{ route('admin.add.product') }}" class="btn btn-primary pull-right">Add Product</a>
            <div class="clearfix"></div>
        </div>
        <div>
          <div class="x_content">   
            <table id="product_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sl. No</th>
                    <th>Product Name</th>
                    <th>Product Photo</th>
                    <th>Product Price</th>
                    <th>Action</th>
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
            var i = 1;
            var table = $('#product_list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: "50",
                ajax: "{{ route('admin.ajax.product_list') }}",
                columns: [
                    { "render": function(data, type, full, meta) {return i++;}},
                    {data: 'name', name: 'name',searchable: true},
                    {data: 'image', name: 'image',searchable: true},
                    {data: 'price', name: 'price',searchable: true},
                    {data: 'action', name: 'action',searchable: true}
                ]
            });
            
        });
     </script>
     @endsection