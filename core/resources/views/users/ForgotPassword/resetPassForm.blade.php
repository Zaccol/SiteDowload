@extends('users.layout.loginMaster')

@section('title', 'Reset Password Form')

@section('content')
  <!-- Login Section Start -->

    <div class="login-admin login-admin1" style="padding:0px 100px;">
      <div class="login-header">
        <h2>Rénitialiser<span>Mot de passe</span></h2>
      </div>
      <div class="login-form">
        <form action="{{route('users.resetPassword')}}" method="post">
          {{csrf_field()}}
          <input type="hidden" name="code" value="{{$code}}">
          <input type="hidden" name="email" value="{{$email}}">
          <input type="password" name="password" placeholder="Mot de passe">
          @if ($errors->has('password'))
              <span style="color: red;">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif
          <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="Entrer à nouveau le mot de passe" >
          @if ($errors->has('password_confirmation'))
              <span style="color: red;">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
              </span>
          @endif
          <input type="submit" value="Connexion">

        </form>
      </div>
      </div>
    </div>
@endsection
