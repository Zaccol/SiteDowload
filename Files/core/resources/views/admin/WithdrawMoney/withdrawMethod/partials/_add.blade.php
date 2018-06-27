{{-- Add Modal --}}
<div class="modal container fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; margin-top: 0px;">
   <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
         <h4 class="modal-title" id="myModalLabel"> <b class="abir_act">Add</b> Withdraw Method</h4>
      </div>
      <form id="addMethodForm" method="POST" action="{{route('withdrawMethod.store')}}">
         <div class="modal-body">
            {{csrf_field()}}
            <input class="form-control" type="hidden" name="id" value="1">
            <div class="row">
               <div class="form-group">
                  <label class="col-md-12"><strong style="text-transform: uppercase;">Method Name</strong></label>
                  <div class="col-md-12">
                     <input class="form-control input-lg" name="methodName" placeholder="" type="text">
                     <p class="error-message text-danger"></p>
                  </div>
               </div>
            </div>
            <br><br>
            <div class="row">
               <div class="form-group">
                  <label class="col-md-12"><strong style="text-transform: uppercase;">Process Time</strong></label>
                  <div class="col-md-12">
                     <div class="input-group mb15">
                        <input class="form-control input-lg" name="processTime" value="" type="text">
                        <span class="input-group-addon">DAYS</span>
                     </div>
                     <p class="error-message text-danger"></p>
                  </div>
               </div>
            </div>
            <br><br>
            <div class="row">
               <div class="col-md-6">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Limit Per Transaction</h1>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="col-md-12"><strong style="text-transform: uppercase;">MINIMUM</strong></label>
                                 <div class="col-md-12">
                                    <div class="input-group mb15">
                                       <input class="form-control input-lg" name="minimum" value="" type="text">
                                       <span class="input-group-addon">{{$gs->base_curr_text}}</span>
                                    </div>
                                    <p class="error-message text-danger"></p>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label class="col-md-12"><strong style="text-transform: uppercase;">MAXIMUM</strong></label>
                                 <div class="col-md-12">
                                    <div class="input-group mb15">
                                       <input class="form-control input-lg" name="maximum" value="" type="text">
                                       <span class="input-group-addon">{{$gs->base_curr_text}}</span>
                                    </div>
                                    <p class="error-message text-danger"></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- row 2nd   -->
                     </div>
                  </div>
               </div>
               <!-- col-6   -->
               <div class="col-md-6">
                  <div class="panel panel-primary">
                     <div class="panel-heading">
                        <h1 class="panel-title" style="text-transform: uppercase; font-weight: bold;">Charge Per Transaction</h1>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-5">
                              <br>
                              <div class="input-group mb15">
                                 <input class="form-control input-lg" name="charged" value="" type="text">
                                 <span class="input-group-addon">{{$gs->base_curr_text}}</span>
                              </div>
                              <p class="error-message text-danger"></p>
                           </div>
                           <div class="col-md-2"><br><b class="btn btn-success btn-lg btn-block">AND</b></div>
                           <div class="col-md-5">
                              <br>
                              <div class="input-group mb15">
                                 <input class="form-control input-lg" name="chargep" value="" type="text">
                                 <span class="input-group-addon">%</span>
                              </div>
                              <p class="error-message text-danger"></p>
                           </div>
                        </div>
                        <!-- row 2nd   -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Method</button>
         </div>
      </form>
   </div>
</div>

{{-- @push('scripts')
   <script>
      function storeMethod(e) {
         e.preventDefault();
         var form = document.getElementById('addMethodForm');
         var fd = new FormData(form);

         $.ajax({
            url: "{{route('withdrawMethod.store')}}",
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
               console.log(data);
               var em = document.getElementsByClassName("error-message");
               // after returning from the controller we are clearing the
               // previous error messages...
               for(i=0; i<em.length; i++) {
                  em[i].innerHTML = '';
               }

               // if data is saved in database successfully...
               if (data == "success") {
                  $("#addModal").modal('hide');
                  document.getElementById('addMethodForm').reset();
                  $("#wmsContainerID").load(location.href + " #wmsContainerID");
               }

               // Showing error message in the HTML...
               if(typeof data.error != 'undefined') {
                  if(typeof data.methodName != 'undefined') {
                     em[0].innerHTML = data.methodName[0];
                  }
                  if(typeof data.processTime != 'undefined') {
                     em[1].innerHTML = data.processTime[0];
                  }
                  if(typeof data.minimum != 'undefined') {
                     em[2].innerHTML = data.minimum[0];
                  }
                  if(typeof data.maximum != 'undefined') {
                     em[3].innerHTML = data.maximum[0];
                  }
                  if(typeof data.charged != 'undefined') {
                     em[4].innerHTML = data.charged[0];
                  }
                  if(typeof data.chargep != 'undefined') {
                     em[5].innerHTML = data.chargep[0];
                  }
               }
               if(data != "success" && data.error == 'undefined') {
                 $("#addModal").modal('hide');
                 swal('Sorry!', 'This is a demo version', 'error');
               }
            }
         });
      }
   </script>
@endpush --}}
