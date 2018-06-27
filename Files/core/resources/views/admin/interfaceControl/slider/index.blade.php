@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:393px">
        <h3 class="page-title  uppercase bold"><i class="fa fa-file-image-o"></i> SET Home Sliders</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <div class="portlet light bordered">
                 <div class="portlet-body form">
                   @if ($errors->any())
                       <div class="alert alert-danger">
                           <ul>
                               @foreach ($errors->all() as $error)
                                   <li>{{ $error }}</li>
                               @endforeach
                           </ul>
                       </div>
                   @endif
                    <form class="form-horizontal" action="{{route('admin.slider.store')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                       <div class="form-body">
                          <div class="form-group">
                             <label class="col-sm-3 control-label"><strong>SLIDER IMAGE</strong></label>
                             <div class="col-sm-3"><input type="file" name="slider"></div>
                             <div class="col-sm-3"><b style="color:red; font-weight: bold;"> Will Resized To 1360 X 550</b></div>
                          </div>
                          <div class="form-group">
                             <label class="col-sm-3 control-label"><strong>Bold Text</strong></label>
                             <div class="col-sm-6"><input type="text" name="btxt" class="form-control input-lg"></div>
                          </div>
                          <div class="form-group">
                             <label class="col-sm-3 control-label"><strong>Small Text</strong></label>
                             <div class="col-sm-6"><input type="text" name="stxt" class="form-control input-lg"></div>
                          </div>
                          <div class="row">
                             <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn blue btn-block">ADD NEW</button>
                             </div>
                          </div>
                       </div>
                    </form>
                 </div>
              </div>
              @if (count($sliders) == 0)
              <div class="portlet box red">
                 <div class="portlet-title">
                    <div class="caption">
                       SLIDER DETAILS
                    </div>
                 </div>
                 <div class="portlet-body">
                   <h1 class="text-center">NO DATA FOUND</h1>
                 </div>
              </div>
              @else
              @foreach ($sliders as $slider)

              <div class="col-md-4 col-sm-12" id="1">
                 <div class="portlet box blue">
                    <div class="portlet-title">
                       <div class="caption">SLIDER DETAILS</div>
                    </div>
                    <div class="portlet-body">
                       <img src={{asset("assets/users/interfaceControl/slider_images/".$slider->image)}} alt="IMG" style="width:100%;"><br>
                       <h3 style="font-weight:bold; min-height:40px;">{{$slider->bold_text}} </h3>
                       {{$slider->small_text}} <br><br>
                       <form class="" action="{{route('admin.slider.delete')}}" method="post">
                         {{csrf_field()}}
                         <input type="hidden" name="sliderID" value="{{$slider->id}}">
                         <button type="submit" class="btn btn-danger btn-block delete_button">
                         <i class="fa fa-times"></i>  DELETE
                         </button>
                       </form>
                    </div>
                 </div>
              </div>
              @endforeach
              @endif
           </div>
        </div>
        <!---ROW-->
     </div>
     <!-- END CONTENT BODY -->
  </div>
@endsection
