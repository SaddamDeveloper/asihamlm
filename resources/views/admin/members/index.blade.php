@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Members</h2>
            <div class="clearfix"></div>
        </div>
        @if (Session::has('message'))
            <div class="alert alert-success" >{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="x_content">
            <table id="member_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sl. No</th>
                    <th>Sponsor ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Left BV</th>
                    <th>Right BV</th>
                    <th>Total BV</th>
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
  </div>
</div>
 @endsection
 
@section('script')
<script type="text/javascript">
    $(function () {
        var i = 1;
        var table = $('#member_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.ajax.member_list') }}",
            columns: [
                { "render": function(data, type, full, meta) {return i++;}},
                {data: 'login_id', name: 'login_id',searchable: true},
                {data: 'name', name: 'name',searchable: true},
                {data: 'mobile', name: 'mobile',searchable: true},
                {data: 'left_bv', name: 'left_bv',searchable: true},
                {data: 'right_bv', name: 'right_bv',searchable: true},
                {data: 'total_bv', name: 'total_bv',searchable: true},
                {data: 'status', name: 'status', render:function(data, type, row){
                    if (row.status == '1') {
                    return "<button class='btn btn-info'>Active</a>"
                    }else{
                    return "<button class='btn btn-danger'>Deactive</a>"
                    }                        
                }},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
   });
</script>
@endsection