
@extends('admin.template.admin_master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
        <div class="row">
                <div class="col-md-12" style="margin-top:50px;">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Withdraw List</h2>
                            <div class="clearfix"></div>
                        </div>
                    <div>
                    @if (Session::has('message'))
                        <div class="alert alert-success" >{{ Session::get('message') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif
                    <div class="x_content">
                        <table id="withdraw_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>                       
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                {{-- <div class="col-md-2"></div> --}}
        </div>
</div>
<!-- /page content -->
@endsection

@section('script')
     <script type="text/javascript">
         $(function () {
             var i = 1;
            var table = $('#withdraw_list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 50,
                ajax: "{{ route('admin.ajax.withdraw') }}",
                columns: [
                    { "render": function(data, type, full, meta) {return i++;}},
                    {data: 'name', name: 'name',searchable: true},
                    {data: 'amount', name: 'amount' ,searchable: true},  
                    {data: 'created_at', name: 'created_at' ,searchable: true}, 
                    {data: 'status', name: 'status', render:function(data, type, row){
                      if (row.status == '1') {
                        return "<label class='label label-info'>Waiting</label>"
                      }else{
                        return "<label class='label label-success'>Paid</label>"
                      }                        
                    }},      
                    {data: 'action', name: 'action' ,searchable: true},  
                ]
            });
            
        });
     </script>
@endsection




