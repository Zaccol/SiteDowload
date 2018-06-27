@extends('users.layout.master')

@section('title', 'SMS Verification')

@section('content')
  <!-- Change Password Form START -->
  {{-- <section class="change-password-section section-padding section-background">

    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3"> --}}
          <div class="login-admin" style="padding:0px 100px;">
            <div class="login-header">
              <h4 style="">A code has been sent to your phone please enter the code to verify your phone number</h4>
            </div>
            <div class="login-form">
              @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">
                  {{session('error')}}
                </div>
              @endif
              <form action="{{route('checkSmsVerification')}}" method="POST">
                {{csrf_field()}}
                <input style="margin-bottom:10px;" type="text" name="sms_ver_code" placeholder="Enter your verification code">
                @if ($errors->has('sms_ver_code'))
                  <p style="margin-bottom:10px;color:red;">{{$errors->first('sms_ver_code')}}</p>
                @endif
                <input type="submit" value="Submit">
              </form>
            </div>
          </div>
        {{-- </div>
      </div>
    </div>
  </section> --}}

  <!-- Change Password Form END -->
@endsection
