<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Asiha MLM | Member Dashboard</title>
    {{-- <link rel="icon" href="{{ asset('logo/logo.png')}}" type="image/icon type"> --}}


    <!-- Bootstrap -->
    <link href="{{asset('admin/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('admin/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('admin/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
  
    <!-- bootstrap-progressbar -->
    <link href="{{asset('admin/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('admin/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('admin/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    {{-- Datatables --}}
     <link href="{{asset('admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

    {{-- pnotify --}}
    
   {{--  <link href="{{asset('admin/src_files/vendors/pnotify/dist/pnotify.css')}}" rel="stylesheet">
    <link href="{{asset('admin/src_files/vendors/pnotify/dist/pnotify.buttons.css')}}" rel="stylesheet">
    <link href="{{asset('admin/src_files/vendors/pnotify/dist/pnotify.nonblock.css')}}" rel="stylesheet"> --}}

    <!-- Custom Theme Style -->
    <link href="{{asset('admin/build/css/custom.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/build/css/tree.css')}}" rel="stylesheet">
    @yield('css')
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{route('admin.deshboard')}}" class="site_title">
                Asiha MLM
                {{-- <img src="{{ asset('logo/logo.png')}}" height="50" style=" width: 50%;"> --}}
              </a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
            {{--   <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div> --}}
              <div class="profile_info">
                <span>Welcome, <b>{{ Auth::guard('member')->user()->name }}</b></span>
                
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="{{ route('member.dashboard')}}"><i class="fa fa-home"></i> Home </span></a>
                  </li>
                  <li><a href="{{route('member.register')}}"><i class="fa fa-user-plus"></i> Member Registration</a>
                  </li>
                
                  <li><a><i class="fa fa-code-fork"></i>My Downline <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('member.tree')}}"> My Tree</a></li>
                      <li><a href="{{route('member.downline')}}"> Downline List</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-credit-card"></i>Wallet <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('member.wallet')}}"> Wallet History</a></li>
                      <li><a href="{{route('member.wallet_balance')}}">Add Wallet Balance</a></li>
                      <li><a href="{{route('member.withdraw')}}">Withdraw Request</a></li>
                    </ul>
                  </li>
                  <li><a href="{{route('member.commission')}}"><i class="fa fa-percent"></i> Commission History</a>
                  </li>
                  <li><a href="{{route('member.change_password_form')}}"><i class="fa fa-key" aria-hidden="true"></i>Change Password</a></li>

                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="#">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li><a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
             <form id="logout-form" action="{{ route('member.logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->