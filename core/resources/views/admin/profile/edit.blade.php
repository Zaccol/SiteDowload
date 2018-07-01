@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:361px">
        <h3 class="page-title uppercase bold"> Profile Management</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <div class="portlet light bordered">
                 <div class="portlet-body form">
                    <form class="form-horizontal" action="{{route('admin.updateProfile', $admin->id)}}" method="post">
                       {{csrf_field()}}
                       <input type="hidden" name="adminID" value="{{$admin->id}}">
                       <div class="form-body">
                          <div class="form-group">
                             <label class="col-md-3 control-label"><strong>FULL NAME</strong></label>
                             <div class="col-md-6">
                                <input class="form-control input-lg" name="name" value="{{$admin->name}}" placeholder="Your Full Name" type="text">
                                @if ($errors->has('name'))
                                  <p style="margin:0px;" class="text-danger">{{$errors->first('name')}}</p>
                                @endif
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="col-md-3 control-label"><strong>EMAIL</strong></label>
                             <div class="col-md-6">
                                <input class="form-control input-lg" name="email" value="{{$admin->email}}" placeholder="Your Email" type="email">
                                @if ($errors->has('email'))
                                  <p style="margin:0px;" class="text-danger">{{$errors->first('email')}}</p>
                                @endif
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="col-md-3 control-label"><strong>MOBILE</strong></label>
                             <div class="col-md-6">
                                <input class="form-control input-lg" name="phone" value="{{$admin->phone}}" placeholder="Your Mobile Number" type="text">
                                @if ($errors->has('phone'))
                                  <p style="margin:0px;" class="text-danger">{{$errors->first('phone')}}</p>
                                @endif
                             </div>
                          </div>
                          <div class="row">
                             <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn blue btn-block">UPDATE</button>
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
