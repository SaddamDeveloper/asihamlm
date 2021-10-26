
@extends('admin.template.admin_master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
        <div class="row">
                <div class="col-md-12" style="margin-top:50px;">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Allocate Fund</h2>
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
                                <a href="{{route('admin.allocate_fund')}}" class="btn btn-primary">Allocate Fund</a>
                            </div>
                        </div>
                        <div>
                            <div class="x_content">
                                <table id="fund_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                  <thead>
                                    <tr>
                                      <th>Sl. No</th>
                                      <th>Name</th>
                                      <th>Amount</th>
                                      <th>Created At</th>
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
                {{-- <div class="col-md-2"></div> --}}
        </div>
</div>
<!-- /page content -->
@endsection

@section('script')
     <script type="text/javascript">
         $(function () {
             var i = 1;
            var table = $('#fund_list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 50,
                ajax: "{{ route('admin.ajax.funds_list') }}",
                columns: [
                    { "render": function(data, type, full, meta) {return i++;}},
                    {data: 'name', name: 'name',searchable: true},
                    {data: 'amount', name: 'amount' ,searchable: true},  
                    {data: 'updated_at', name: 'updated_at' ,searchable: true}, 
                    {data: 'action', name: 'action' ,searchable: true},  
                ]
            });
            
        });
     </script>
@endsection




