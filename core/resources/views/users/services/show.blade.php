@extends('users.layout.master')

@push('styles')
  <style media="screen">

    .content-container {
      padding:0px 50px;
    }

    @media screen and (max-width: 500px) {
      .content-container {
        padding:0px 0px;
      }

    }

  </style>
@endpush

@section('meta-ajax')
	<meta name="_token" content="{{ csrf_token() }}" />
@endsection

@section('title', 'Service Details')

@section('servicePrice')
  <div class="widget-content">
     <div class="widget__title card__header card__header--has-btn">
        <div class="widget_title1">
           <h4>Price</h4>
        </div>
     </div>
     <div class="widget__content card__content">
        <div class="bet-winer-sidebar">
          <div class="panel-body selected-bet-user">
          </div>
          <div class="panel-footer user-bet-footer">
             <div class="right">
                Service Price
                <span id="total_bet_amount"><b>{{$service->price}} </b></span> {{$gs->base_curr_symbol}}
             </div>
             <div class="left">
                <input type="hidden" id="total_amount" name="total_amount" value="">
                <button type="button" class="btn btn-success btn-sm" onclick="placeOrder({{$service->id}})">Order Now</button>
             </div>
           </div>
        </div>
     </div>
  </div>
@endsection

@section('content')
  <div class="content-container">
      <h1 style="">{{$service->service_title}}</h1>
      <div class="">
        @if (count($service->serviceImages) == 1)
          <img src="{{asset('assets/users/service_images/' . $service->serviceImages->first()->image_name)}}" alt="">
        @else
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
              @for ($i=0; $i < count($service->serviceImages); $i++)
                <li data-target="#carousel-example-generic" data-slide-to="{{$i}}" {{$i==0 ? 'class="active"' : ''}}></li>
              @endfor
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
              @foreach ($service->serviceImages as $serviceImage)
                <div class="item {{($loop->first) ? 'active' : ''}}">
                  <img style="width:100%" src="{{asset('assets/users/service_images/' . $serviceImage->image_name)}}" alt="...">
                </div>
              @endforeach
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        @endif
      </div><br>
      <div class="">
        <p style="">
          <strong>Category: </strong>
          {{$service->category->name}}
        </p>
        <p style="">
          <strong>Tags: </strong>
          @foreach ($service->tags as $tag)
            <span class="badge">{{$tag->name}}</span>
          @endforeach
        </p>
        <p style=""><strong>Maximum Days to Complete: </strong>{{$service->max_days}} days</p>
        <div class="jumbotron">
          <h2 class="text-center">Description</h2>
          <p>{!!$service->description!!}</p>
        </div>
        @auth
          @if (Auth::user()->id != $service->user->id)
            <div class="row text-center">
              <p><strong>Price: </strong>{{$service->price}} {{$gs->base_curr_symbol}}</p>
              <button type="button" class="btn btn-danger btn-lg" onclick="placeOrder({{$service->id}})">Order Now</button>
            </div><br>
          @endif
        @endauth

        <div class="fb-comments" data-href="{{url()->current()}}" data-numposts="5"></div>

      </div>
  </div>
@endsection

{{-- Components order place snackbars components... --}}
@component('users.components.balanceShortage')
@endcomponent
@component('users.components.success')
@endcomponent

@push('scripts')
  @auth
    <script>
        function placeOrder(serviceID) {
          var fd = new FormData();
          fd.append('serviceID', serviceID);
          $.ajaxSetup({
              headers: {
                  'X-CSRF-Token': $('meta[name=_token]').attr('content')
              }
          });
          // console.log(token + ' ' + serviceID);
          var c = confirm('Are you sure you want to place this order?');

          if(c == true) {
            $.ajax({
              url: '{{route('buyer.placeOrder')}}',
              type: 'POST',
              data: fd,
              contentType: false,
              processData: false,
              success: function(data) {
                // if user balance runs into shortage...
                console.log(data);
                if(typeof data.balance != 'undefined') {
                  var snackbar = document.getElementById('snackbar');
                  snackbar.innerHTML = "You don't have enough balance to buy this Gig!";
                  snackbar.className = "show";
                  setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
                }
                 // if order is placed successfully...
                else {
                  var url = "{{route('buyer.contactOrder')}}/" + data;
                  var snackbarSuccess = document.getElementById('snackbarSuccess');
                  snackbarSuccess.innerHTML = "Order has been placed successfully!";
                  snackbarSuccess.className = "show";
                  setTimeout(function() {
                    snackbarSuccess.className = snackbarSuccess.className.replace("show", "");
                  }, 3000);
                  window.location.href = url;
                }
              }
            });
          }

        }
    </script>
  @endauth
  @guest
    <script>
      function placeOrder(serviceID) {
        window.location = '{{route('login')}}';
      }
    </script>
  @endguest
@endpush
