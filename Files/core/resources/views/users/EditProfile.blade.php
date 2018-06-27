@extends('users.layout.master')

@section('title', 'Edit Profile')

@section('profile-info')
  {{-- START: Profile Info... --}}
  <div class="widget-content">
    <div class="widget__content card__content extar-margin">
      <div class="panel-group" id="accordion">
           <div class="panel">
                <div class="panel-heading side-events-item">
                  <div class="">
                    <div>
                        <img style="display:block;margin:auto;" src="{{asset('assets/users/propics/' . $user->pro_pic)}}" alt="">
                    </div>
                 </div>
                </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <h2 style="color:white;margin:0px;"><a style="text-decoration:underline;" href="{{route('users.profile', $user->id)}}">{{$user->username}}</a></h2>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-plus" aria-hidden="true"></i> Join Date</strong> Apr 22, 2018
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-star" aria-hidden="true"></i> Buyer Rating</strong> 90%
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-thumbs-o-up"></i> Positive Rating</strong> 9
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-thumbs-o-down"></i> Negative Rating</strong> 1
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-eye" aria-hidden="true"></i> Last Seen</strong> Today
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
      </div>
    </div>
  </div>
  {{-- END: Profile Info... --}}
@endsection

@push('styles')
  <style media="screen">
    .login-admin {
      padding:0px 50px;
    }
    @media screen and (max-width: 500px) {
      .login-admin {
        padding:0px;
      }
    }
  </style>
@endpush

@section('content')
  <!-- Register Section Start -->
  {{-- <section class="register-section section-padding section-background">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3"> --}}
          <div class="login-admin">
            <div class="login-header">
              <h2>Edit Profile</span></h2>
            </div>
            <div class="login-form">
              @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                  {{session('success')}}
                </div
              @endif
              <form action="{{route('updateProfile')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                @method('PUT')
                <strong>Profile Picture:</strong><br>
                <label class="btn btn-success" style="width:200px;cursor:pointer;margin-left:-2px;margin-top:5px;">
                  <input id="proPic" name="proPic" style="display:none;" type="file" />Choose File
                </label>
                @if ($errors->has('proPic'))
                    <p>
                      <p style="color:red;">
                        <strong>{{ $errors->first('proPic') }}</strong>
                      </p>
                    </p>
                @endif
                <br>
                <strong>First Name:</strong><br>
                <input type="text" name="firstname" placeholder="Firstname" value="{{$user->firstname}}">
                @if ($errors->has('firstname'))
                    <p style="color:red;">
                        <strong>{{ $errors->first('firstname') }}</strong>
                    </p>
                @endif
                <strong>Last Name:</strong><br>
                <input type="text" name="lastname" placeholder="Lastname" value="{{$user->lastname}}">
                @if ($errors->has('lastname'))
                    <p style="color:red;">
                        <strong>{{ $errors->first('lastname') }}</strong>
                    </p>
                @endif
                <br>
                <strong>Address:</strong><br>
                <input type="text" name="address" value="{{$user->address}}" placeholder="Address">
                <br>
                <strong>Zip Code:</strong><br>
                <input type="text" name="zip" value="{{$user->zip}}" placeholder="Zip Code">
                <br>
                <strong>Country:</strong><br>
                <input type="text" name="country" value="{{$user->country}}" placeholder="Country Name">
                @if ($errors->has('country'))
                    <p style="color:red;">
                        <strong>{{ $errors->first('country') }}</strong>
                    </p>
                @endif
                <input type="submit" value="UPDATE PROFILE">
              </form>
            </div>
          </div>
        {{-- </div>
      </div>
    </div>
  </section> --}}

  <!-- Register Section End -->
@endsection
