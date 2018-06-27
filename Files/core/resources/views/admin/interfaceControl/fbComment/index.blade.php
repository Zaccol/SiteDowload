@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
          <!-- BEGIN CONTENT BODY -->
          <div class="page-content" style="min-height:811px">
              <!-- BEGIN PAGE HEADER-->
              <!-- BEGIN PAGE TITLE-->
              <h3 class="page-title"> <b> Comment Script</b></h3>
              <!-- END PAGE TITLE-->
              <!-- END PAGE HEADER-->
                  <div class="row">
          <div class="col-md-12">
              <div class="portlet light bordered">
                  <div class="portlet-body form">
                      <form class="form-horizontal" method="post" role="form" action="{{route('admin.fbComment.update')}}">
                          {{csrf_field()}}
                          <div class="form-body">

                              <div class="form-group">
                                  <label class="col-md-12"><strong style="text-transform: uppercase;"> Comment Script</strong></label>
                                  <div class="col-md-12">
                                      <textarea id="area1" class="form-control" rows="15" name="comment_script">{{$gs->comment_script}}</textarea>
                                  </div>
                              </div>
                              <br>
                              <br>
                              <div class="row">
                                  <div class="col-md-12">
                                      <button type="submit" class="btn blue btn-block btn-lg"><i class="fa fa-send"></i> Update Script</button>
                                  </div>
                              </div>

                          </div>
                      </form>

                  </div>
              </div>
          </div>
      </div><!---ROW-->


          </div>
          <!-- END CONTENT BODY -->
      </div>
@endsection
