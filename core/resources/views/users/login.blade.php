@extends('users.layout.loginMaster')

@section('title', 'Login')

@push('styles')
    <style media="screen">
        .login-admin1 {
          padding:0px 100px;
        }
        @media screen and (max-width: 500px) {
            .login-admin1 {
                padding: 0px 10px;
            }
        }
    </style>
@endpush

@section('content')
  <!-- Login Section Start -->

    <div class="login-admin login-admin1" style="">
      <div class="login-header">
        <h2>Existing <span>customer</span></h2>
      </div>
      <div class="login-form">
        <form action="{{route('login')}}" method="post">
          {{csrf_field()}}
          <input type="text" name="username" value="{{old('username')}}" placeholder="Enter Username" >
          @if ($errors->has('username'))
              <span style="color: red;">
                  <strong>{{ $errors->first('username') }}</strong>
              </span>
          @endif
          <input type="password" name="password" placeholder="Password">
          @if ($errors->has('password'))
              <span style="color: red;">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif
          <input type="submit" value="Login">

          {{-- <label for="check" > <input type="checkbox" id="#check" >Remember me</label> --}}
          <a href="{{route('users.showEmailForm')}}">Forgot my password</a>
          {{-- <p>You can log in by using your Facebook or Twitter accounts.</p> --}}
        </form>
      </div>
      {{-- <div class="social-login">
        <ul>
          <li><a href="#"><i class="fa fa-facebook"></i>log in with facebook</a></li>
          <li><a href="#"><i class="fa fa-twitter"></i>log in twitter</a></li>
        </ul> --}}
      </div>
    </div>

@endsection
