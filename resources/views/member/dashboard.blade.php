@extends('member.template.admin_master')

@section('content')

        <!-- page content -->
    <div class="right_col" role="main">
        <div class="row tile_count">
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-rupee"></i> My Commission</span>
            <div class="count">{{number_format($commission, 2)}}</div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Pair Completed</span>
              <div class="count">{{$total_pair}}</div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-cc-visa"></i> My Wallet</span>
              <div class="count">00</div>
            </div>
        </div>
            
            <!-- /top tiles -->
            <br />
        {{-- <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">                
                        <th class="column-title">Sl No. </th>
                        <th class="column-title">Member ID</th>
                        <th class="column-title">Member Name</th>
                        <th class="column-title">Document Verify</th>
                        <th class="column-title">Document Status</th>
                        <th class="column-title">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @if(isset($latest_members) && !empty($latest_members) && count($latest_members) > 0)
                    @php
                        $count = 1;
                    @endphp

                    @foreach($latest_members as $members)
                        <tr class="even pointer">
                            <td class=" ">{{ $count++ }}</td>
                            <td><label class="label label-success">{{ $members->member_id }}</label></td>
                            <td class=" ">{{ $members->name }}</td>
                            <td>
                            @if($members->document_status == 1)
                                <label class="label label-success">VERIFIED</label>
                            @elseif($members->document_status == 2)
                                <label class="label label-warning">NOT VERIFIED</label>
                            @else
                                <label class="label label-warning">REJECTED</label>
                            @endif
                            </td>
                            <td>
                            @if($members->document_u_status == 1)
                                <label class="label label-success">UPLOADED</label>
                            @elseif($members->document_u_status == 2)
                                <label class="label label-warning">NOT UPLOADED</label>
                            @else
                                <label class="label label-warning">NOT UPLOADED</label>
                            @endif
                            </td>
                            <td>
                            @if($members->status == 1)  
                                <button class="btn btn-success">Active</button>
                            @else
                                <button class="btn btn-danger">Deactive</button>
                            @endif
                            </td>  
                        </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5" style="text-align: center">Sorry No Data Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <a href="{{route('admin.mem_member_list')}}" class="btn btn-primary pull-right">More...</a>
        </div> --}}
    </div>
 @endsection