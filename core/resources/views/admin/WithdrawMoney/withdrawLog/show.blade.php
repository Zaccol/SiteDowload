@extends('admin.layout.master')

{{-- All necessary JS for NIC Editor --}}
@push('nic-editor-scripts')
  <script src="{{asset('assets/admin/js/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
          new nicEditor({iconsPath : "{{asset('assets/admin/js/nic-edit/nicEditorIcons.gif')}}"}).panelInstance('actionTextarea');
    });
  </script>
@endpush

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:361px">
        <h3 class="page-title uppercase bold"> Withdraw Details</h3>
        <hr>
        <div class="row">
          <div id="withdrawInfo">
            <div class="col-md-6">
               <div class="portlet box blue">
                  <div class="portlet-title">
                     <div class="caption uppercase bold">
                        <i class="fa fa-upload"></i> Withdraw Request
                     </div>
                  </div>
                  <div class="portlet-body">
                     <div class="table-scrollable">
                        <table class="table table-bordered table-hover">
                           <tbody>
                              <tr class="bold">
                                 <td> Requested By </td>
                                 <td>
                                    <a href="http://idealbrothers.thesoftking.com/walletv2/admin/UserDetails/2266"> {{$withdraw->user->username}}</a>
                                    ( <i>{{$withdraw->user->email}}</i> )
                                 </td>
                              </tr>
                              <tr class="bold">
                                 <td> Requested On </td>
                                 <td>{{$withdraw->created_at->format('l jS \\of F Y h:i:s A')}} </td>
                              </tr>
                              <tr class="bold">
                                 <td> Transaction # </td>
                                 <td>{{$withdraw->trx}}</td>
                              </tr>
                              <tr class="bold">
                                 <td> Method </td>
                                 <td>{{$withdraw->withdrawMethod->name}}</td>
                              </tr>
                              <tr class="bold">
                                 <td> Amount </td>
                                 <td>{{$withdraw->amount}} {{$gs->base_curr_text}}</td>
                              </tr>
                              <tr class="bold">
                                 <td> Charge </td>
                                 <td>{{$withdraw->charge}} {{$gs->base_curr_text}}</td>
                              </tr>
                              <tr class="bold">
                                 <td> Status </td>
                                 <td><button class="btn btn-warning"> {{$withdraw->status}}</button></td>
                              </tr>
                              <tr class="bold">
                                 <td> Details </td>
                                 <td>{{$withdraw->details}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <i style="color: red;"> *** Charge Already taken. Send <strong>{{$withdraw->amount}}  {{$gs->base_curr_text}}</strong> To The User</i>
                  </div>
               </div>
            </div>
          </div>
           <div class="col-md-6">
              <div class="portlet box green">
                 <div class="portlet-title">
                    <div class="caption uppercase bold">
                       <i class="fa fa-cogs"></i> Take Action
                    </div>
                 </div>
                 <div class="portlet-body">
                    <form id="messageFormID" method="post">
                       <strong style="text-transform: uppercase;">Message or Reason</strong><br><br>
                       {{csrf_field()}}
                       <textarea id="actionTextarea" name="message" rows="8" style="width:100%;"></textarea>
                       <p id="withdrawLogMessageError" class="text-danger"></p>

                       <div class="row">
                          <div class="col-md-6">
                             <button onclick="storeMessage('processed', {{$withdraw->id}})" type="button" name="val" value="1" class="btn blue btn-block btn-lg">PROCESSED</button>
                          </div>
                          <div class="col-md-6">
                             <button onclick="storeMessage('refunded', {{$withdraw->id}})" type="button" name="val" value="2" class="btn red btn-block btn-lg">REFUND</button>
                          </div>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
        </div>
        <!-- row -->
     </div>
  </div>
@endsection

@push('scripts')
  <script>
    function storeMessage(status, wID) {
      var form = document.getElementById('messageFormID');
      var fd = new FormData(form);
      fd.append('wID', wID);
      fd.append('status', status);
      var nicE = new nicEditors.findEditor('actionTextarea');
      message = nicE.getContent();
      fd.append('message', message);
      $.ajax({
        url: '{{route('withdrawLog.message.store')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);
          document.getElementById('withdrawLogMessageError').innerHTML = '';
          if(data == "success") {
            nicE.setContent('');
            document.getElementById('messageFormID').reset();
            $("#withdrawInfo").load(location.href + " #withdrawInfo");
            swal('Success', '', 'success');

          }
          if(typeof data.error != 'undefined') {
            document.getElementById('withdrawLogMessageError').innerHTML = data.message[0];
          }
          if (data != "success" && typeof data.error == 'undefined') {
            swal('Sorry', 'This is Demo version. You can not change anything.', 'error');
          }
        }
      });
    }
  </script>
@endpush
