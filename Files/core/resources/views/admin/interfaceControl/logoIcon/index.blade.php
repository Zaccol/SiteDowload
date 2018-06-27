@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:792px">
        <h3 class="page-title  uppercase bold"> Logo and Icon Setting</h3>
        <hr>
        <div class="row">
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif          
           <div class="col-md-4">
              <div class="portlet box green">
                 <div class="portlet-title">
                    <div class="caption"><i class="fa fa-repeat"></i> CHANGE IMAGES</div>
                 </div>
                 <div class="portlet-body">
                    <form action="{{route('admin.logoIcon.update')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                       <div class="row">
                          <div class="form-group">
                             <label class="col-md-12"><strong style="text-transform: uppercase;">logo</strong></label>
                             <div class="col-sm-12"><input name="logo" type="file" id="logo"></div>
                             <p class="col-md-12"><strong>[Upload 220 X 35 image for best quality]</strong></p>
                             {{-- <input name="abir" type="hidden" value="bgimg"> --}}
                             <br>
                             <br>
                          </div>
                          <br>
                          <br>
                          <br>
                          <div class="form-group">
                             <label class="col-md-12"><strong style="text-transform: uppercase;">favicon</strong></label>
                             <div class="col-sm-12"><input name="icon" type="file" id="icon"></div>
                             <p class="col-md-12"><strong>[Upload 25 X 25 image for best quality]</strong></p>
                             <br>
                             <br>
                          </div>
                          <br>
                          <br>
                          <br>
                          <div class="form-group">
                             <div class="col-sm-12"> <button type="submit" class="btn btn-primary btn-block">UPLOAD</button></div>
                          </div>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
           <div class="col-md-4">
              <div class="portlet box blue">
                 <div class="portlet-title">
                    <div class="caption"><i class="fa fa-desktop"></i> CURRENT ICON</div>
                 </div>
                 <div class="portlet-body">
                    <img src="{{asset('assets/users/interfaceControl/logoIcon/icon.jpg')}}" alt="icon" style="width: 100%;">
                    <br /><br />
                    <p>Upload <strong>40X40 pixels</strong> for best quality</p>
                 </div>
              </div>
           </div>
           <div class="col-md-4">
              <div class="portlet box blue">
                 <div class="portlet-title">
                    <div class="caption"><i class="fa fa-desktop"></i> CURRENT LOGO</div>
                 </div>
                 <div class="portlet-body">
                    <img src="{{asset("assets/users/interfaceControl/logoIcon/logo.jpg")}}" alt="LOGO" style="width: 100%;">
                    <br /><br />
                    <p>Upload <strong>160X40 pixels</strong> for best quality</p>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
@endsection
