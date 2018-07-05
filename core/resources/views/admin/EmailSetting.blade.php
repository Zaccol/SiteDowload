@extends('admin.layout.master')

{{-- All necessary JS for NIC Editor --}}
@push('nic-editor-scripts')
  <script src="{{asset('assets/admin/js/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
          new nicEditor({iconsPath : "{{asset('assets/admin/js/nic-edit/nicEditorIcons.gif')}}"}).panelInstance('emailTemplate');
    });
  </script>
@endpush

@section('body')
<div class="page-content-wrapper">
    <div class="page-content">

        <h3 class="page-title uppercase bold"> {{$data['page_title']}}</h3>
        <hr>
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                    <i class="fa fa-bookmark"></i>Short Code</div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> CODE </th>
                                    <th> DESCRIPTION </th>
                                </tr>
                            </thead>
                            <tbody>


                                <tr>
                                    <td> 1 </td>
                                    <td> <pre>@{{message}}</pre> </td>
                                    <td> Details Text From Script</td>
                                </tr>

                                <tr>
                                    <td> 2 </td>
                                    <td> <pre>@{{name}}</pre> </td>
                                    <td> Users Name. Will Pull From Database and Use in EMAIL text</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>

        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">

            <div class="portlet-body form">
                <form class="form-horizontal" action="{{route('admin.UpdateEmailSetting')}}" method="post">
                    {{csrf_field()}}
                    <div class="form-body">

                        <div class="form-group">
                            <div class="col-md-12">
                              <label class="control-label"><strong style="text-transform: uppercase;">Email Sent From</strong><br></label>
                              <div class="col-md-112">
                                  <input class="form-control input-lg" name="emailSentFrom" value="{{$gs->email_sent_from}}" type="text">
                                  @if ($errors->has('emailSentFrom'))
                                    <span style="color:red;">{{$errors->first('emailSentFrom')}}</span>
                                  @endif
                              </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12">
                              <label class="control-label"><strong style="text-transform: uppercase;">Email Template</strong><br></label>
                            </div>
                            <div class="col-md-12">
                              {{-- NIC Editor... --}}
                              <textarea class="form-control" id="emailTemplate" name="emailTemplate" rows="20" cols="80" style="width:100%;">{{$gs->email_template}}</textarea>
                              @if ($errors->has('emailTemplate'))
                                <span style="color:red;">{{$errors->first('emailTemplate')}}</span>
                              @endif
                            </div>
                        </div>



                        <br>
                        <br>
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
        <p style="clear:both;"></p>

    </div>
</div>
@endsection
