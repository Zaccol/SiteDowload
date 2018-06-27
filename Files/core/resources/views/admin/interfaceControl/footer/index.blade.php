@extends('admin.layout.master')

{{-- All necessary JS for NIC Editor --}}
@push('nic-editor-scripts')
  <script src="{{asset('assets/admin/js/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
          new nicEditor({iconsPath : "{{asset('assets/admin/js/nic-edit/nicEditorIcons.gif')}}"}).panelInstance('footerTextArea');
    });
  </script>
@endpush

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:392px">
        <h3 class="page-title uppercase bold">set Footer text</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <!-- BEGIN SAMPLE FORM PORTLET-->
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
                    <form class="form-horizontal" action="{{route('admin.footer.update')}}" method="post" role="form">
                      {{csrf_field()}}
                       <div class="form-body">
                          <div class="form-group">
                             <label class="col-md-12"><strong style="text-transform: uppercase;">TEXT</strong></label>
                             <div class="col-md-12">
                                <textarea id="footerTextArea" style="width:100%;" class="form-control" name="footer" rows="8" cols="80">{!! $footer->footer !!}</textarea>
                             </div>
                          </div>
                          <br>
                          <div class="row">
                             <div class="col-md-12">
                                <button type="submit" class="btn blue btn-block btn-lg">UPDATE</button>
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
