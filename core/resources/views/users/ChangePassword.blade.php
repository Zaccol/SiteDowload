@extends('users.layout.master')

@push('styles')
  <style media="screen">
    input:not(.updateBtn) {
      background-color: white !important;
    }
    .login-admin {
      padding:0px 100px;
    }
    @media screen and (max-width: 500px) {
      .login-admin {
        padding:0px;
      }
    }
  </style>
@endpush

@section('title', 'Password Change')

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

@section('content')
  <!-- Change Password Form START -->
  {{-- <section class="change-password-section section-padding section-background">

    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3"> --}}
          <div class="login-admin">
            <div class="login-header">
              <h2>Change Password</h2>
            </div>
            <div class="login-form">
              @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                  {{session('success')}}
                </div>
              @endif
              <form action="{{route('updatePassword')}}" method="POST">
                {{csrf_field()}}
                @method('PUT')
                <input type="password" name="old_password" placeholder="Old Password">
                @if ($errors->has('old_password'))
                    <span style="color:red;">
                        <strong>{{ $errors->first('old_password') }}</strong>
                    </span>
                @else
                    @if ($errors->first('oldPassMatch'))
                        <span style="color:red;">
                            <strong>{{"Old password doesn't match with the existing password!"}}</strong>
                        </span>
                    @endif
                @endif

                <input type="password" name="password" placeholder="New Password">
                @if ($errors->has('password'))
                    <span style="color:red;">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <input type="password" name="password_confirmation" placeholder="Confirm Password">
                <input class="updateBtn" type="submit" value="Update Password">
              </form>
            </div>
          </div>
        {{-- </div>
      </div>
    </div>
  </section> --}}

  <!-- Change Password Form END -->
@endsection
