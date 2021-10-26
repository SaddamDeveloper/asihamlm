@extends('member.template.admin_master')

@section('content')

<div class="right_col" role="main">
  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Commission History</h2>
            <div class="clearfix"></div>
        </div>
        <div>
          <div class="x_content">
            <table id="commission_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sl. No</th>
                    <th>Pair Number</th>
                    <th>Amount</th>
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
      </div>
    </div>
  </div>
</div>
 @endsection
 @section('script')
 <script type="text/javascript">
     $(function () {
        var i = 1;
        var table = $('#commission_list').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: "50",
            ajax: "{{ route('member.ajax.commission') }}",
            columns: [
                { "render": function(data, type, full, meta) {return i++;}},
                {data: 'pair_number', name: 'pair_number',searchable: true},
                {data: 'amount', name: 'amount',searchable: true},
                {data: 'comment', name: 'comment',searchable: true},
                {data: 'status', name: 'status', render:function(data, type, row){
                  if (row.status == '1') {
                    return "<label class='label label-success rounded'>Credited</label>"
                  }else if(row.status == '2'){
                    return "<label class='label label-warning rounded'>Capping</label>"
                  }else if(row.status == '4'){
                    return "<label class='label label-danger rounded'>Debited</label>"
                  }                        
                }},              
                {data: 'created_at', name: 'created_at',searchable: true},
            ]
        });
    });
 </script>
@endsection