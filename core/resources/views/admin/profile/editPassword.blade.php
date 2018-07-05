@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:361px">
        <h3 class="page-title uppercase bold"> Change Password</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <div class="portlet light bordered">
                 <div class="portlet-body form">
                    <form class="form-horizontal" action="{{route('admin.updatePassword')}}" method="post" role="form">
                       {{csrf_field()}}
                       <div class="form-body">
                          <div class="form-group">
                             <label class="col-md-3 control-label"><strong>Current Password</strong></label>
                             <div class="col-md-6">
                                <input class="form-control input-lg" name="old_password" placeholder="Your Current Password" type="password">
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
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="col-md-3 control-label"><strong>New Password</strong></label>
                             <div class="col-md-6">
                                <input class="form-control input-lg" name="password" placeholder="New Password" type="password">
                                @if ($errors->has('password'))
                                <span style="color:red;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="col-md-3 control-label"><strong>New Password Again</strong></label>
                             <div class="col-md-6">
                                <input class="form-control input-lg" name="password_confirmation" placeholder="New Password Again" type="password">
                             </div>
                          </div>
                          <div class="row">
                             <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn blue btn-block">Submit</button>
                             </div>
                          </div>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
        </div>
        <!---ROW-->
     </div>
  </div>
@endsection
