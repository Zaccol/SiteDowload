@extends('admin.layout.master')

{{-- All necessary JS for NIC Editor --}}
@push('nic-editor-scripts')
  <script src="{{asset('assets/admin/js/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
          new nicEditor({iconsPath : "{{asset('assets/admin/js/nic-edit/nicEditorIcons.gif')}}"}).panelInstance('emailMessage');
    });
  </script>
@endpush

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:361px">
        <h3 class="page-title uppercase bold"> <i class="fa fa-envelope"></i> Send email to user</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <div class="portlet box blue">
                 <div class="portlet-title">
                    <div class="caption uppercase bold">
                       <i class="fa fa-envelope"></i>  Send email to {{$user->username}}
                    </div>
                 </div>
                 <div class="portlet-body">
                    <form action="{{route('admin.sendEmailToUser')}}" method="post">
                       {{csrf_field()}}
                       <input type="hidden" name="userID" value="{{$user->id}}">
                       <div class="row uppercase">
                          <div class="col-md-12">
                             <div class="form-group">
                                <label class="col-md-12"><strong>SUBJECT</strong></label>
                                <div class="col-md-12">
                                   <input class="form-control input-lg" name="subject" type="text" value="{{old('subject')}}">
                                   @if ($errors->has('subject'))
                                     <p style="margin:0px;" class="text-danger">{{ $errors->first('subject') }}</p>
                                   @endif
                                </div>
                             </div>
                          </div>
                       </div>
                       <!-- row -->
                       <br>
                       <div class="row uppercase">
                          <div class="col-md-12">
                             <div class="form-group">
                                <label class="col-md-12"><strong>Message</strong> NB: EMAIL WILL SENT USING EMAIL TEMPLATE</label>
                                <div class="col-md-12">
                                   <textarea name="message" rows="10" class="form-control" id="emailMessage" style="width: 100%;">{{old('message')}}</textarea>
                                   @if ($errors->has('message'))
                                     <p style="margin:0px;" class="text-danger">{{ $errors->first('message') }}</p>
                                   @endif
                                </div>
                             </div>
                          </div>
                       </div>
                       <!-- row -->
                       <br>
                       <div class="row uppercase">
                          <div class="col-md-12">
                             <button type="submit" class="btn btn-success btn-lg btn-block"> SUBMIT </button>
                          </div>
                       </div>
                       <!-- row -->
                    </form>
                 </div>
              </div>
           </div>
        </div>
        <!-- ROW-->
     </div>
  </div>
@endsection
