@extends('member.template.admin_master')

@section('content')

<div class="right_col" role="main">
  <div class="row">

    <div class="col-md-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Wallet History</h2>
            <div class="text-center"> <h3>Wallet Balance: ₹ {{ number_format($wallet->amount, 2) }}</h3></div>
            <div class="clearfix"></div>
        </div>
        <div>
          <div class="x_content">
            <table id="wallet_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Sl. No</th>
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
      </div>
    </div>
  </div>
</div>
 @endsection

 @section('script')
     <script type="text/javascript">
         $(function () {
            var i = 1;
            var table = $('#wallet_list').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: "50",
                ajax: "{{ route('member.ajax.wallet') }}",
                columns: [
                    { "render": function(data, type, full, meta) {return i++;}},
                    {data: 'amount', name: 'amount',searchable: true},
                    {data: 'total_amount', name: 'total_amount',searchable: true},
                    {data: 'comment', name: 'comment',searchable: true},
                    {data: 'transaction_type', name: 'transaction_type', render:function(data, type, row){
                      if (row.transaction_type == '1') {
                        return "<label class='label label-success rounded'>Cr</label>"
                      }else{
                        return "<label class='label label-warning rounded'>Dr</label>"
                      }                        
                    }},              
                    {data: 'created_at', name: 'created_at',searchable: true},
                ]
            });
        });
     </script>
@endsection
