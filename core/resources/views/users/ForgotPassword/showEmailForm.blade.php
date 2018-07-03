@extends('users.layout.loginMaster')

@section('title', 'Reset Password Mail Form')

@section('content')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      @if (session()->has('alert'))
        <div class="alert alert-danger">
          {{session('alert')}}
        </div>
      @endif
      @if (session()->has('message'))
        <div class="alert alert-success">
          {{session('message')}}
        </div>
      @endif

      <form id="sendResetPassMailForm" action="{{route('users.sendResetPassMail')}}" class="" method="post">
        {{csrf_field()}}
        <div class="form-group">
          <label for=""><strong style="font-size:25px;">Email:</strong></label>
          <input placeholder="Enter your mail address" class="form-control" type="email" name="resetEmail" value="" style="height:60px;">
          @if ($errors->has('resetEmail'))
            <p class="text-danger">{{$errors->first('resetEmail')}}</p>
          @endif
        </div>
        <div class="form-group text-center">
          <input class="btn btn-success" type="submit" name="" value="Send Reset Password Mail">
        </div>
      </form>
    </div>
  </div>
@endsection

{{-- @push('scripts')
  <script>
      function sendResetPassMail() {
        var form = document.getElementById('sendResetPassMailForm');
        var fd = new FormData(fd);
        $.ajax({
          url: '{{route()}}',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function() {

          }
        });
      }
  </script>
@endpush --}}
