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
    <link rel="stylesheet" href="{{asset('assets/users/css/style.css')}}">
    <!--Responsive Css-->
    <link href="{{asset('assets/users/css/responsive.css')}}" rel="stylesheet">
    {{-- Base Color Change... --}}
    <link href="{{url('/')}}/assets/admin/css/themes/base-color.php?color={{$gs->base_color_code}}&secColor={{$gs->sec_color_code}}" rel="stylesheet">
    <script src="{{asset('assets/users/js/jquery.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{asset('assets/users/css/multi-item-slide.css')}}">
    <link rel="stylesheet" href="{{asset('assets/users/css/scrollbar.css')}}">
    <script src="{{asset('assets/users/js/multi-item-slide.js')}}"></script>
    @stack('styles')
    @stack('scripts')
    @stack('nic-editor-scripts')
    {{--
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    --}}

    <style media="screen">
        .search-bar {
            padding: 30px 0px;
        }
    </style>
</head>
<body  data-spy="scroll">
<!-- End Preload -->
<!-- <div class="animation-element">

    <div class="support-bar-top wow slideInLeft" data-wow-duration="2s" id="raindrops-green">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-info">
                        <span style="color:white;margin-right:10px;"><i class="fa fa-envelope email" aria-hidden="true"></i> {{$gs->email}}</span>
                        <span style="color:white;"><i class="fa fa-phone" aria-hidden="true"></i> {{$gs->phone}}</span>
                    </div>
                </div>
                <div class="col-md-6 text-right bounceIn">
                    <div class="contact-admin">
                        @guest
                            <a href="{{route('login')}}"><i class="fa fa-user"></i> LOGIN </a>
                            <a href="{{route('register')}}"><i class="fa fa-user-plus"></i> REGISTER</a>
                        @endguest
                        <div class="support-bar-social-links">
                            @foreach ($socials as $social)
                                <a href="{{$social->url}}"><i class="fa fa-{{$social->fontawesome_code}}" aria-hidden="true"></i></a>
                            @endforeach

                            {{-- <a href="http://thesoftking.com/contact"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
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

            <!-- <div class="col-md-offset-1 col-md-3 col-xs-8 col-xs-offset-2 search-bar">
                <form class="" action="{{route('users.searchServices')}}" method="get">
                    <input placeholder="Search Services Here..." class="form-control" type="text" name="searchTerm" value="">
                </form>
            </div> -->

            <div class="col-md-9 text-right">
                <ul id="header-menu" class="header-navigation">
                    <!-- <li><a href="{{route('users.home')}}">Home</a></li> -->
                    {{-- <li><a href="{{route('inbox')}}">Inbox</a></li> --}}
                    @auth
                        <li>
                            <a class="page-scroll" href="#">
                                 Achats <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="mega-menu mega-menu1 mega-menu2 menu-position-5 buyer-dropdown">
                                <li class="mega-list mega-list1">
                                    <a class="page-scroll" href="{{route('buyer.myShopping')}}">Contrats achetés</a>
                                </li>
                            </ul>
                        </li>
                    @endauth
                    @auth
                        <li>
                            <a class="page-scroll" href="#">
                                annonces <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="mega-menu mega-menu1 mega-menu2 menu-postion-2">
                                <li class="mega-list mega-list1">
                                    <a class="page-scroll" href="{{route('services.create')}}">Créer une annonce</a>
                                    <a class="page-scroll" href="{{route('services.index')}}">Gérer mes annonces</a>
                                    <a class="page-scroll" href="{{route('seller.manageSales')}}">contrats vendu</a>
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
                                Nous rejoindre <i class="fa fa-angle-down"></i>
                            @endguest
                        </a>
                        @guest
                            <ul class="mega-menu mega-menu1 mega-menu2 menu-postion-4">
                                <li class="mega-list mega-list1">
                                    <a class="page-scroll" href="{{route('login')}}">Connexion</a>
                                    <a class="page-scroll" href="{{route('register')}}">Inscription</a>
                                </li>
                            </ul>
@endguest
                        @auth
                            <ul class="mega-menu mega-menu1 mega-menu2 menu-postion-4">
                                <li class="mega-list mega-list1">
                                    <a class="page-scroll" href="{{route('users.profile', Auth::user()->id)}}">Profil</a>
                                    <a class="page-scroll" href="{{route('addFund')}}">Créditer le compte</a>
                                    <a class="page-scroll" href="{{route('withdrawMoney')}}">récupérer les crédits</a>
                                    <a class="page-scroll" href="{{route('editProfile')}}">éditer le profil</a>
                                    <a class="page-scroll" href="{{route('editPassword')}}">Changer le mot de passe</a>
                                    <a style="cursor:pointer;" class="page-scroll" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Deconnexion</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        @endauth
                    </li>
                    {{-- <li><a href="#">$ {{Auth::user()->balance}}</a></li> --}}
                </ul>
            </div>
        </div>
    </div>
</nav>
<div>
    @yield('carousel')
</div>
<div class="clearfix"></div>
<div class="bet-section">
    <div style="padding:0px 20px;">
        <div class="row">


            <div class="col-sm-12">
                <div class="col-sm-10">
                    @yield('content')
                </div>
                <div class="col-sm-2">
                    <aside class="right">
                        @php
                            $smallAd = show_ad(1);
                        @endphp
                        <div class="widget-content">
                            <!-- <div class="panel-advertise">
                                @if ($smallAd[0]->type == 1)
                                    <a onclick="increaseAdView({{$smallAd[0]->id}})" href="{{$smallAd[0]->url}}" target="_blank">
                                        <img style="width:100%;" src="{{asset('assets/users/ad_images/'.$smallAd[0]->image)}}" alt="addvertisement-02">
                                    </a>
                                @else
                                    {!! $smallAd[0]->script !!}
                                @endif
                            </div> -->
                        </div>
                        <!-- <div class="widget-content">
                            <div class="widget__title card__header card__header--has-btn">
                                <div class="widget_title1">
                                    <h4>Services</h4>
                                </div>
                            </div>
                            <marquee scrollamount="5" onmouseover="this.stop()" onmouseout="this.start()" direction = "up" style="height:350px;overflow:hidden;">
                                <div class="widget__content card__content widget_list">
                                    @foreach ($featuredGigs as $featuredGig)
                                        <div class="side-category-item">
                                            <p style="margin:0px;"><a href="{{route('services.show', ['id'=>$featuredGig->id, 'userID'=>$featuredGig->user->id])}}"><b>{{$featuredGig->service_title}}</b></a></p>
                                            <h5> <span class="label label-primary pull-right">Featured</span> <span class="label label-danger pull-right">Price: {{$featuredGig->price}} {{$gs->base_curr_symbol}}</span></h5>
                                        </div>
                                    @endforeach
                                </div>
                            </marquee>
                        </div> -->


                        <div class="widget-content">
                            <div class="widget__title card__header card__header--has-btn">
                                <div class="widget_title1">
                                    <h4>Catégories</h4>
                                </div>
                            </div>
                            <div  class="widget__content card__content widget_list">
                                @foreach ($categories as $category)
                                    <div class="side-category-item">
                                        <a href="{{route('users.servicesAccoordingToCat', $category->id)}}"><b>{{$category->name}}</b></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @php
                            $longAd = show_ad(3);
                        @endphp
                        {{-- left side top long ad --}}
                        <!-- <div class="widget-content">
                            <div class="panel-advertise">
                                @if ($longAd[0]->type == 1)
                                    <a onclick="increaseAdView({{$longAd[0]->id}})" href="{{$longAd[0]->url}}" target="_blank">
                                        <img style="width:100%;" src="{{asset('assets/users/ad_images/'.$longAd[0]->image)}}" alt="addvertisement-02">
                                    </a>
                                @else
                                    {!! $longAd[0]->script !!}
                                @endif
                            </div>
                        </div> -->
                    </aside>
                </div>
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
<!--payment method section start-->
<!-- <section class="client-section client-section1 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header wow zoomInDown" data-wow-duration="2s">
                    <h2>PAYMENT <span> WE ACCEPT</span></h2>
                    <p><img src="{{asset('assets/users/interfaceControl/logoIcon/icon.jpg')}}" alt="icon"></p>
                </div>

                <div class="section-wrapper">
                    <div class="client-list">

                        <div class="carousel slide row" data-ride="carousel" data-type="multi" data-interval="2000" id="fruitscarousel">

                            <div class="carousel-inner">
                                @foreach ($gateways as $gateway)
                                    @if ($loop->first)
                                        <div class="item active">
                                            <div class="col-sm-2 col-xs-12">
                                                <img src="{{asset('assets/users/img/gateway/' . $gateway->gateimg)}}" alt="">
                                            </div>
                                        </div>
                                    @else
                                        <div class="item">
                                            <div class="col-sm-2 col-xs-12">
                                                <img src="{{asset('assets/users/img/gateway/' . $gateway->gateimg)}}" alt="">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <a class="left carousel-control" href="#fruitscarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
                            <a class="right carousel-control" href="#fruitscarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

</section> -->
<!--end payment method section start-->
<!--footer area start-->
<footer id="contact" class="footer-area">
    <!--footer area start-->
    <div class="footer-bottom">
        <div class="footer-support-bar">
            <!-- Footer Support List Start -->
            <!-- <div class="footer-support-list">
                <ul>
                    @foreach ($supports as $support)
                        <li class="wow bounceInDown" data-wow-duration="1s" data-wow-delay="1s">
                            <div class="footer-thumb"><i class="fa fa-{{$support->fontawesome_code}}"></i></div>
                            <div class="footer-content">
                                <p>{{$support->title}}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div> -->
            <!-- Footer Support End -->
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12 wow fadeInLeft" data-wow-duration="3s">
                    <p class="copyright-text">
                    </p>
                </div>
                <div class="col-md-4 col-sm-9 wow bounceInDown" data-wow-duration="3s">
                    <p class="copyright-text">
                        {!! $gs->footer !!}
                    </p>
                </div>
                <div class="col-md-4 col-sm-3 wow fadeInRight" data-wow-duration="3s">
                </div>
            </div>
        </div>
    </div>
    <div id="back-to-top" class="scroll-top back-to-top" data-original-title="" title="" >
        <i class="fa fa-angle-up"></i>
    </div>
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
{{-- Increase Ad Views... --}}
<script>
    function increaseAdView(adID) {
        var fd = new FormData();
        fd.append('adID', adID);
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=_token]').attr('content')
            }
        });
        $.ajax({
            url: '{{route('admin.ad.increaseAdView')}}',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
            }
        });
    }
</script>
</body>
</html>
