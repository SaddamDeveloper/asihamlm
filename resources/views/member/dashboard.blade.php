@extends('member.template.admin_master')

@section('content')
    <div class="right_col" role="main">
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-user"></i></div>
                <div class="count">{{ $member->sponsor_id }}</div>
                <h3>{{ $member->name }}</h3>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-calendar"></i></div>
                <div class="count">{{ $member->created_at->format('d/m/Y') }}</div>
                <h3>Joining Date</h3>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-street-view"></i></div>
                <div class="count">13</div>
                <h3>Direct Member</h3>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-arrow-left"></i></div>
                <div class="count">{{ $tree->total_left_count }}</div>
                <h3>Total Left</h3>
              </div>
            </div>
          </div>
            <div class="row top_tiles">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                      <div class="icon"><i class="fa fa-arrow-right"></i></div>
                      <div class="count">{{ $tree->total_right_count }}</div>
                      <h3>Total Right</h3>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                      <div class="icon"><i class="fa fa-sitemap"></i></div>
                      <div class="count">{{ $tree->total_left_count }}</div>
                      <h3>Left BV</h3>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                      <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                      <div class="count">{{ $tree->total_right_count }}</div>
                      <h3>Right BV</h3>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                      <div class="icon"><i class="fa fa-check-square-o"></i></div>
                      <div class="count">{{ $tree->total_pair }}</div>
                      <h3>Matching BV</h3>
                    </div>
                  </div>
            </div>
            <!-- /top tiles -->
            <br />
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">                
                        <th class="column-title">Sl No. </th>
                        <th class="column-title">Sponsor ID</th>
                        <th class="column-title">Member Name</th>
                        <th class="column-title">Mobile</th>
                        <th class="column-title">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @if(isset($downline_member) && !empty($downline_member) > 0)
                    @php
                        $count = 1;
                    @endphp

                    @foreach($downline_member as $members)
                        <tr class="even pointer">
                            <td class=" ">{{ $count++ }}</td>
                            <td><label class="label label-success">{{ $members->sponsor_id }}</label></td>
                            <td class=" ">{{ $members->name }}</td>
                            <td> {{ $members->mobile }} </td>
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
            <a href="{{route('member.downline')}}" class="btn btn-primary pull-right">More...</a>
        </div>
    </div>
 @endsection