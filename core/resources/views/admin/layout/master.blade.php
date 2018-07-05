<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{ $gs->website_title }} - Admin</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('meta-ajax')
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <!--Favicon add-->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/users/interfaceControl/logoIcon/icon.jpg')}}">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('assets/admin/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/darkblue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{asset('assets/admin/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/bootstrap-modal-bs3patch.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/bootstrap-modal.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/admin/css/sweetalert.css')}}">
    @stack('styles')
    @stack('nic-editor-scripts')
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="{{route('admin.dashboard')}}">
                    <img src="{{asset('assets/users/interfaceControl/logoIcon/logo.jpg')}}" alt="logo" class="logo-default" style="width: 160px; height: 20px;"> </a>
                    <div class="menu-toggler sidebar-toggler"> </div>
                </div>

                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>

                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username"> {{ Auth::guard('admin')->user()->username }}  </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li><a href="{{route('admin.editPassword')}}"><i class="fa fa-cog"></i> Change Password </a></li>
                                <li><a href="{{route('admin.editProfile', Auth::user()->id)}}"><i class="fa fa-user"></i> Profile Management </a></li>
                                <li><a href="{{route('admin.logout')}}"><i class="fa fa-sign-out"></i> Log Out </a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

                        <!-- <li class="sidebar-toggler-wrapper hide">
                            <div class="sidebar-toggler"> </div>


</li> -->

<li class="nav-item start @if(request()->path() == 'admin/Dashboard') active open @endif">
    <a href="{{route('admin.dashboard')}}" class="nav-link "><i class="fa fa-home"></i><span class="title">Dashboard</span></a>
</li>


                        <li class="nav-item start
                        @if(request()->path() == 'admin/categoryManagement/index') active open
                        @endif">
                            <a href="{{route('admin.category.index')}}" class="nav-link "><i class="fa fa-tags"></i><span class="title">Category Management</span></a>
                        </li>

                        <li class="nav-item

                            @if(request()->path() == 'admin/gigManagement/allGigs') active open
                            @elseif (request()->path() == 'admin/gigManagement/hiddenGigs') active open
                            @elseif (request()->path() == 'admin/gigManagement/featuredGigs') active open
                            @endif">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-tasks"></i>
                                <span class="title">Services Management</span><span class="arrow"></span>
                            </a>

                            <ul class="sub-menu">

                                <li class="nav-item">
                                    <a href="{{route('gigManagement.allGigs')}}" class="nav-link "><i class="fa fa-tasks"></i><span class="title">All Services</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('gigManagement.hiddenGigs')}}" class="nav-link "><i class="fa fa-tasks"></i><span class="title">Hidden Services</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('gigManagement.featuredGigs')}}" class="nav-link "><i class="fa fa-tasks"></i><span class="title">Featured Services</span></a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item start
                        @if(request()->path() == 'admin/gateways') active open
                        @endif">
                            <a href="{{route('admin.gateways')}}" class="nav-link "><i class="fa fa-credit-card"></i><span class="title">Gateways</span></a>
                        </li>

                        <li class="nav-item start
                        @if(request()->path() == 'admin/depositLog') active open
                        @endif">
                            <a href="{{route('admin.depositLog')}}" class="nav-link "><i class="fa fa-download" aria-hidden="true"></i><span class="title">Deposit Log</span></a>
                        </li>

                        <li class="nav-item
                            @if(request()->path() == 'admin/withdrawLog') active open
                            @elseif(request()->path() == 'admin/withdrawMethod') active open
                            @elseif(request()->path() == 'admin/successLog') active open
                            @elseif(request()->path() == 'admin/refundedLog') active open
                            @elseif(request()->path() == 'admin/pendingLog') active open
                            @endif">
                            <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-upload"></i>
                                <span class="title">Withdraw Money</span><span class="arrow"></span></a>

                                <ul class="sub-menu">

                                    <li class="nav-item">
                                        <a href="{{route('admin.withdrawMethod')}}" class="nav-link"><i class="fa fa-cog"></i> Withdraw Method</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.withdrawLog')}}" class="nav-link"><i class="fa fa-desktop"></i> Withdraw Log </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.withdrawMoney.pendingLog')}}" class="nav-link"><i class="fa fa-desktop"></i> Pending Requests Log</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.withdrawMoney.successLog')}}" class="nav-link"><i class="fa fa-desktop"></i> Success Log</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.withdrawMoney.refundedLog')}}" class="nav-link"><i class="fa fa-desktop"></i> Refunded Log</a>
                                    </li>

                                </ul>
                            </li>

                            <li class="nav-item start
                            @if(request()->path() == 'admin/interfaceControl/Ad/index') active open
                            @endif">
                                <a href="{{route('admin.ad.index')}}" class="nav-link "><i class="fa fa-buysellads"></i><span class="title">Advertisement</span></a>
                            </li>

                            <li class="nav-item
                                @if(request()->path() == 'admin/userManagement/allUsers') active open
                                @elseif(request()->path() == 'admin/userManagement/bannedUsers') active open
                                @elseif(request()->path() == 'admin/userManagement/verifiedUsers') active open
                                @elseif(request()->path() == 'admin/userManagement/mobileUnverifiedUsers') active open
                                @elseif(request()->path() == 'admin/userManagement/emailUnverifiedUsers') active open
                                @endif">
                                <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-user" aria-hidden="true"></i></i>
                                    <span class="title">Users Management</span><span class="arrow"></span></a>

                                    <ul class="sub-menu">

                                        <li class="nav-item">
                                            <a href="{{route('admin.allUsers')}}" class="nav-link"><i class="fa fa-user" aria-hidden="true"></i> All Users</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('admin.bannedUsers')}}" class="nav-link"><i class="fa fa-times"></i> Banned Users </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('admin.verifiedUsers')}}" class="nav-link"><i class="fa fa-check"></i> Verified Users </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('admin.mobileUnverifiedUsers')}}" class="nav-link"><i class="fa fa-mobile"></i> Mobile Unverified </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('admin.emailUnverifiedUsers')}}" class="nav-link"><i class="fa fa-envelope"></i> E-mail Unverified </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="nav-item
                                @if(request()->path() == 'admin/interfaceControl/logoIcon/index') active open
                                @elseif (request()->path() == 'admin/interfaceControl/slider/index') active open
                                @elseif (request()->path() == 'admin/interfaceControl/contact/index') active open
                                @elseif (request()->path() == 'admin/interfaceControl/support/index') active open
                                @elseif (request()->path() == 'admin/interfaceControl/footer/index') active open
                                @elseif (request()->path() == 'admin/interfaceControl/social/index') active open
                                @elseif (request()->path() == 'admin/interfaceControl/fbComments/index') active open
                                @endif">
                                   <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-desktop"></i>
                                   <span class="title">Interface Control</span><span class="arrow"></span></a>
                                   <ul class="sub-menu">
                                      <li class="nav-item">
                                         <a href="{{route('admin.logoIcon.index')}}" class="nav-link"><i class="fa fa-cogs"></i> Logo+icon Setting</a>
                                      </li>
                                      <li class="nav-item">
                                         <a href="{{route('admin.slider.index')}}" class="nav-link"><i class="fa fa-cogs"></i> Slider Setting</a>
                                      </li>
                                      <li class="nav-item">
                                         <a href="{{route('admin.support.index')}}" class="nav-link"><i class="fa fa-cogs"></i> Support Setting</a>
                                      </li>
                                      <li class="nav-item">
                                         <a href="{{route('admin.footer.index')}}" class="nav-link"><i class="fa fa-cogs"></i> Footer Text</a>
                                      </li>
                                      <li class="nav-item">
                                         <a href="{{route('admin.social.index')}}" class="nav-link"><i class="fa fa-cogs"></i> Social Setting</a>
                                      </li>
                                      <li class="nav-item">
                                         <a href="{{route('admin.contact.index')}}" class="nav-link"><i class="fa fa-cogs"></i> Contact Setting</a>
                                      </li>
                                      <li class="nav-item">
                                         <a href="{{route('admin.fbComment.index')}}" class="nav-link"><i class="fa fa-cogs"></i> Comment Script</a>
                                      </li>
                                   </ul>
                                </li>

                                <li class="nav-item

                                        @if(request()->path() == 'admin/GeneralSetting') active open
                                        @elseif(request()->path() == 'admin/EmailSetting') active open
                                        @elseif(request()->path() == 'admin/SmsSetting') active open
                                    @endif">
                                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-bars"></i>
                                        <span class="title">Website Control</span><span class="arrow"></span></a>

                                        <ul class="sub-menu">

                                            <li class="nav-item">
                                                <a href="{{route('admin.GenSetting')}}" class="nav-link"><i class="fa fa-cogs"></i> General Setting </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('admin.EmailSetting')}}" class="nav-link"><i class="fa fa-envelope"></i> Email Setting </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('admin.SmsSetting')}}" class="nav-link"><i class="fa fa-mobile"></i> SMS Setting </a>
                                            </li>

                                        </ul>
                                    </li>

                        </ul>
                    </div>
                </div>


                @yield('body')



            </div>
            <div class="page-footer">
                <div class="page-footer-inner"> {{ date("Y")}} &copy; {{$data['sitename']}}</div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>


            @stack('scripts')


            <!-- JavaScripts -->
            <script src="{{asset('assets/admin/js/jquery.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/bootstrap.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/js.cookie.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/jquery.blockui.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/app.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/layout.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/jquery.waypoints.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/jquery.counterup.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/datatable.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/datatables.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/datatables.bootstrap.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/table-datatables-buttons.min.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/bootstrap-modalmanager.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/bootstrap-modal.js')}}" type="text/javascript"></script>
            <script src="{{asset('assets/admin/js/bootstrap-toggle.min.js')}}"></script>

           @yield('script')






@if (session('success'))
<script type="text/javascript">
        $(document).ready(function(){
            swal("Success!", "{{ session('success') }}", "success");
        });
</script>
@endif

@if (session('alert'))
<script type="text/javascript">
        $(document).ready(function(){
            swal("Sorry!", "{{ session('alert') }}", "error");
        });
</script>
@endif



        </body>
        </html>
