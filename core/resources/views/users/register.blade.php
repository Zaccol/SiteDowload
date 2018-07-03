@extends('users.layout.loginMaster')

@section('title', 'Register')

@push('styles')
  <style media="screen">
    .login-admin {
      padding:0px 100px;
    }
    @media screen and (max-width: 500px) {
      .login-admin {
        padding:0px 10px;
      }

    }
  </style>
@endpush

@section('content')
  <!-- Register Section Start -->

  <div class="login-admin" style="">
    @if ($errors->has('registration'))
      <div class="alert alert-danger">
        <strong>{{$errors->first('registration')}}</strong>
      </div>
    @endif
    @if ($gs->registration == 0)
      <div style="margin-bottom:10px;">
        <h4 style="color:red;">*** [Registration is currently disabled by Admin] ***</h4>
      </div>
    @endif

    <div class="login-header">
      <h2>Rejoignez-nous !</h2>
    </div>
    <div class="login-form">
      <form action="{{route('register')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="registration" value="{{$gs->registration}}">
        <input type="hidden" name="ref" value="{{$username}}">
        <input type="text" name="username" placeholder="Pseudo" value="{{old('username')}}">
        @if ($errors->has('username'))
            <span style="color:red;">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
        <input type="email" name="email" placeholder="Adresse email" value="{{old('email')}}">
        @if ($errors->has('email'))
            <span style="color:red;">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <input type="text" name="firstname" placeholder="Prénom" value="{{old('firstname')}}">
        @if ($errors->has('firstname'))
            <span style="color:red;">
                <strong>{{ $errors->first('firstname') }}</strong>
            </span>
        @endif
        <input type="text" name="lastname" placeholder="Nom" value="{{old('lastname')}}">
        @if ($errors->has('lastname'))
            <span style="color:red;">
                <strong>{{ $errors->first('lastname') }}</strong>
            </span>
        @endif
        <input type="text" name="country" placeholder="Pays" value="{{old('country')}}">
        @if ($errors->has('country'))
            <span style="color:red;">
                <strong>{{ $errors->first('country') }}</strong>
            </span>
        @endif
        <input type="text" name="phone" placeholder="Numéro de téléphone" value="{{old('phone')}}">
        @if ($errors->has('phone'))
            <span style="color:red;">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
        <input type="password" name="password" placeholder="Mot de passe">
        @if ($errors->has('password'))
            <span style="color:red;">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        <input type="password" name="password_confirmation" placeholder="Confirmez mot de passe ">
        @if ($errors->has('password_confirmation'))
            <span style="color:red;">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
        <input type="submit" value="je m'incris">
      </form>
    </div>
  </div>


  <!-- Register Section End -->
@endsection
