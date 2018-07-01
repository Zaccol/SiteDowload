@extends('users.layout.master')

@section('meta-ajax')
  <meta name="_token" content="{{ csrf_token() }}" />
@endsection

{{-- @section('profile-info')

@endsection --}}

@push('styles')
  <style media="screen">
      .rating-propic-container {
        width:60px;
        float:left;
        margin-right:10px;
        height:60px;
      }
      .comment-propic-container {
        float: left;
        margin-right: 10px;
      }
  </style>
@endpush

@section('title', 'Profile')

@section('content')
  <div class="content-container">
      <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#services">Services</a></li>
          <li><a data-toggle="tab" href="#ratings">Ratings</a></li>
          <li><a data-toggle="tab" href="#comments">Comments</a></li>
      </ul>
      <div class="tab-content">
          <div id="services" class="tab-pane fade in active">
              @includeif('users.profile.partials._services')
          </div>
          <div id="ratings" class="tab-pane fade">
              @includeif('users.profile.partials._ratings')
          </div>
          <div id="comments" class="tab-pane fade">
              @includeif('users.profile.partials._comments')
          </div>
      </div>
  </div>
@endsection
