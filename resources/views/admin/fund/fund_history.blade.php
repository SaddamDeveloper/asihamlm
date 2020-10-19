
@extends('admin.template.admin_master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
        <div class="row">
                <div class="col-md-12" style="margin-top:50px;">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Fund History</h2>
                            <div class="clearfix"></div>
                            <input type="hidden" name="id" value="{{ $user_id }}">
                        </div>
                    <div>
                        @if (Session::has('message'))
                        <div class="alert alert-success" >{{ Session::get('message') }}</div>
                        @endif
                        @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif
                    <div class="x_content">
                        <table id="fund_history" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Total Amount</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>                       
                            </tbody>
                        </table>
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
            var table = $('#fund_history').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 50,
                ajax: "{{ route('admin.ajax.funds_history_list', ['user_id' => $user_id]) }}",
                columns: [
                    { "render": function(data, type, full, meta) {return i++;}},
                    {data: 'name', name: 'name',searchable: true},
                    {data: 'amount', name: 'amount' ,searchable: true},  
                    {data: 'total_amount', name: 'total_amount' ,searchable: true},  
                    {data: 'comment', name: 'comment' ,searchable: true}, 
                    {data: 'status', name: 'status', render:function(data, type, row){
                      if (row.status == '1') {
                        return "<label class='label label-success rounded'>Credited</label>"
                      }else{
                        return "<label class='label label-warning rounded'>Debited</label>"
                      }                        
                    }},   
                    {data: 'created_at', name: 'created_at' ,searchable: true}, 
                ]
            });
            
        });
     </script>
@endsection




