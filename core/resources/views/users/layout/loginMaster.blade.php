<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      @yield('meta-ajax')
      <title>{{$gs->website_title}} | @yield('title')</title>
      <!--Favicon add-->
      <link rel="shortcut icon" type="image/png" href="{{asset('assets/users/interfaceControl/logoIcon/icon.jpg')}}">
      <!--bootstrap Css-->
      <link href="{{asset('assets/users/css/bootstrap.min.css')}}" rel="stylesheet">
      <!--font-awesome Css-->
      <link href="{{asset('assets/users/css/font-awesome.min.css')}}" rel="stylesheet">
      <!-- Lightcase  Css-->
      <link href="{{asset('assets/users/css/lightcase.css')}}" rel="stylesheet">
      <!--WOW Css-->
      <link href="{{asset('assets/users/css/animate.min.css')}}" rel="stylesheet">
      <!--Slick Slider Css-->
      <link href="{{asset('assets/users/css/slick.css')}}" rel="stylesheet">
      <!--Slick Nav Css-->
      <link href="{{asset('assets/users/css/slicknav.min.css')}}" rel="stylesheet">
      <!--Swiper  Css-->
      <link href="{{asset('assets/users/css/swiper.min.css')}}" rel="stylesheet">
      <!--Style Css-->
      <link href="{{asset('assets/users/css/style.css')}}" rel="stylesheet">
      <!--Responsive Css-->
      <link href="{{asset('assets/users/css/responsive.css')}}" rel="stylesheet">
      <link rel="stylesheet" href="{{asset('assets/users/css/style.css')}}">
      {{-- Base Color Change... --}}
      <link href="{{url('/')}}/assets/admin/css/themes/base-color.php?color={{$gs->base_color_code}}&secColor={{$gs->sec_color_code}}" rel="stylesheet">
      <link rel="stylesheet" href="{{asset('assets/users/css/scrollbar.css')}}">
      <link rel="stylesheet" href="{{asset('assets/admin/css/sweetalert.css')}}">
      <script src="{{asset('assets/users/js/jquery.js')}}"></script>
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
      <link rel="stylesheet" href="{{asset('assets/users/css/multi-item-slide.css')}}">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
      <script src="{{asset('assets/users/js/multi-item-slide.js')}}"></script>
      <script src="{{asset('assets/admin/js/sweetalert.js')}}"></script>

      @stack('styles')
      @stack('scripts')
      @stack('nic-editor-scripts')

      <style media="screen">
         .search-bar {
            padding: 30px 0px;
         }
      </style>
      {{--
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
      --}}
   </head>
   <body  data-spy="scroll">
      <!-- End Preload -->

      <!--support bar  top end-->
      <!--main menu section start-->
      <nav class="main-menu wow slideInRight" data-wow-duration="2s">
         <div class="container">
            <div class="row">
               <div class="col-md-3">
                  <div class="logo">
                     <a href="{{route('users.home')}}"><img src="{{asset('assets/users/interfaceControl/logoIcon/logo.jpg')}}" style="max-height:60px;"></a>
                  </div>
               </div>

               <div class="col-md-offset-1 col-md-3 col-xs-8 col-xs-offset-2 search-bar">
                 <!-- <form class="" action="{{route('users.searchServices')}}" method="get">
                    <input placeholder="Search Services Here..." class="form-control" type="text" name="searchTerm" value="">
                 </form> -->
              </div>

               <div class="col-md-5 text-right">
                  <ul id="header-menu" class="header-navigation">

                     {{-- <li><a href="{{route('inbox')}}">Inbox</a></li> --}}
                     @auth
                     <li>
                        <a class="page-scroll" href="#">
                        Contrats <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="mega-menu mega-menu1 mega-menu2 menu-postion-2">
                           <li class="mega-list mega-list1">
                              <a class="page-scroll" href="{{route('buyer.myShopping')}}">Mes achats</a>
                           </li>
                        </ul>
                     </li>
                     @endauth
                     @auth
                     <li>
                        <a class="page-scroll" href="#">
                        Seller <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="mega-menu mega-menu1 mega-menu2 menu-postion-2">
                           <li class="mega-list mega-list1">
                              <a class="page-scroll" href="{{route('services.create')}}">Sell a service</a>
                              <a class="page-scroll" href="{{route('services.index')}}">Manage Services</a>
                              <a class="page-scroll" href="{{route('seller.manageSales')}}">Manage Sales</a>
                           </li>
                        </ul>
                     </li>
                     @endauth
                     <li>
                        <a class="page-scroll" href="#">
                        @auth
                        {{Auth::user()->username}} <i class="fa fa-angle-down"></i>
                        @endauth
                        @guest
                        Nous Rejoindre <i class="fa fa-angle-down"></i>
                        @endguest
                        </a>
                        @guest
                        <ul class="mega-menu mega-menu1 mega-menu2 menu-postion-4">
                           <li class="mega-list mega-list1">
                              <a class="page-scroll" href="{{route('login')}}">connexion</a>
                              <a class="page-scroll" href="{{route('register')}}">inscription</a>
                           </li>
                        </ul>
                        @endguest
                        @auth
                        <ul class="mega-menu mega-menu1 mega-menu2 menu-postion-4">
                           <li class="mega-list mega-list1">
                              <a class="page-scroll" href="{{route('users.profile', Auth::user()->id)}}">Profile</a>
                              <a class="page-scroll" href="{{route('addFund')}}">Add Fund</a>
                              <a class="page-scroll" href="{{route('withdrawMoney')}}">Withdraw Money</a>
                              <a class="page-scroll" href="{{route('editProfile')}}">Edit Profile</a>
                              <a class="page-scroll" href="{{route('editPassword')}}">Change Password</a>
                              <a style="cursor:pointer;" class="page-scroll" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Deconnexion</a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                              </form>
                           </li>
                        </ul>
                        @endauth
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>

      <div class="clearfix"></div>
      <div class="bet-section">
         <div class="container">
            <div class="row">

               <div class="col-sm-8 col-md-offset-2">
                  @yield('content')
               </div>

            </div>
         </div>
      </div>
      </div>
      <!-- Modal Alert for Login -->
      <div class="modal fade" id="login_alert" role="dialog">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"> <i class="fa fa-bell"></i> Login Alert!</h4>
               </div>
               <div class="modal-body">
                  <p>Please login to place bet</p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-info pull-left" data-dismiss="modal">Close</button>
                  <a href="http://localhost/bet_ver_09/login" class="btn btn-success pull-right">Login</a>
               </div>
            </div>
         </div>
      </div>
      <!-- Online Section End -->
      <div class="clearfix"></div>
      <div class="clearfix"></div>

      <!--end payment method section start-->
      <!--footer area start-->
      <footer id="contact" class="footer-area">
         <!--footer area start-->
         <div class="footer-bottom">

            <div class="container">
               <div class="row">
                  <div class="col-md-4 col-sm-12 wow fadeInLeft" data-wow-duration="3s">
                     <p class="copyright-text">
                     </p>
                  </div>
                  <div class="col-md-4 col-sm-9 wow bounceInDown" data-wow-duration="3s">
                     <p class="copyright-text">
                        {!!$gs->footer!!}
                     </p>
                  </div>
                  <div class="col-md-4 col-sm-3 wow fadeInRight" data-wow-duration="3s">
                  </div>
               </div>
            </div>
         </div>
         <!-- <div id="back-to-top" class="scroll-top back-to-top" data-original-title="" title="" >
            <i class="fa fa-angle-up"></i>
         </div> -->
      </footer>
      <!--Google Map APi Key-->
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHzPSV2jshbjI8fqnC_C4L08ffnj5EN3A"></script>
      <!--jquery script load-->
      <script src="{{asset('assets/users/js/jquery.js')}}"></script>
      <script src="{{asset('assets/users/js/bootstrap.min.js')}}"></script>
      <!-- Gmap Load Here -->
      <script src="{{asset('assets/users/js/gmaps.js')}}"></script>
      <!-- Highlight script load-->
      <script src="{{asset('assets/users/js/highlight.min.js')}}"></script>
      <!--Jquery Ui Slider script load-->
      <script src="{{asset('assets/users/js/jquery-ui-slider.min.js')}}"></script>
      <!--Circleful Js File Load-->
      <script src="{{asset('assets/users/js/jquery.circliful.js')}}"></script>
      <!--CounterUp script load-->
      <script src="{{asset('assets/users/js/jquery.counterup.min.js')}}"></script>
      <!-- Ripples  script load-->
      <script src="{{asset('assets/users/js/jquery.ripples-min.js')}}"></script>
      <!--Slick Nav Js File Load-->
      <script src="{{asset('assets/users/js/jquery.slicknav.min.js')}}"></script>
      <!--Lightcase Js File Load-->
      <script src="{{asset('assets/users/js/lightcase.js')}}"></script>
      <!--RainDrops script load-->
      <script src="{{asset('assets/users/js/raindrops.js')}}"></script>
      <!--Easing script load-->
      <script src="{{asset('assets/users/js/easing-min.js')}}"></script>
      <!--Slick Slider Js File Load-->
      <script src="{{asset('assets/users/js/slick.min.js')}}"></script>
      <!--Swiper script load-->
      <script src="{{asset('assets/users/js/swiper.min.js')}}"></script>
      <!--WOW script load-->
      <script src="{{asset('assets/users/js/wow.min.js')}}"></script>
      <!--WayPoints script load-->
      <script src="{{asset('assets/users/js/waypoints.min.js')}}"></script>
      <!--Marquee script load-->
      <script src="{{asset('assets/users/js/marquee.js')}}"></script>
      <!--Main js file load-->
      <script src="{{asset('assets/js/main.js')}}"></script>
      <script>
         var mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
         hljs.initHighlightingOnLoad();
         hljs.configure({useBR: true});
         jQuery('#raindrops').raindrops({color:'#fff',canvasHeight:5});
         jQuery('#raindrops-green').raindrops({color:'#2ecc71 ',canvasHeight:5});
      </script>
      <script>
         $(document).ready(function() {
                 $('div.headlines marquee').marquee('pointer').mouseover(function () {
              $(this).trigger('stop');
            }).mouseout(function () {
              $(this).trigger('start');
            }).mousemove(function (event) {
              if ($(this).data('drag') == true) {
                this.scrollLeft = $(this).data('scrollX') + ($(this).data('x') - event.clientX);
              }
            }).mousedown(function (event) {
              $(this).data('drag', true).data('x', event.clientX).data('scrollX', this.scrollLeft);
            }).mouseup(function () {
              $(this).data('drag', false);
            });
         });
      </script>
      @if (session('alert'))
        <script type="text/javascript">
                $(document).ready(function(){
                    swal("Sorry!", "{{ session('alert') }}", "error");
                });
        </script>
      @endif
   </body>
</html>
