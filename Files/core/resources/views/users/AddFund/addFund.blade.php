@extends('users.layout.master')

@section('title', 'Add Fund')

@section('profile-info')
  {{-- START: Profile Info... --}}
  <div class="widget-content">
    <div class="widget__content card__content extar-margin">
      <div class="panel-group" id="accordion">
           <div class="panel">
                <div class="panel-heading side-events-item">
                  <div class="">
                    <div>
                        <img style="display:block;margin:auto;" src="{{asset('assets/users/propics/' . $user->pro_pic)}}" alt="">
                    </div>
                 </div>
                </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <h2 style="color:white;margin:0px;"><a style="text-decoration:underline;" href="{{route('users.profile', $user->id)}}">{{$user->username}}</a></h2>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-plus" aria-hidden="true"></i> Join Date</strong> Apr 22, 2018
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-star" aria-hidden="true"></i> Buyer Rating</strong> 90%
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-thumbs-o-up"></i> Positive Rating</strong> 9
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-thumbs-o-down"></i> Negative Rating</strong> 1
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-eye" aria-hidden="true"></i> Last Seen</strong> Today
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
      </div>
    </div>
  </div>
  {{-- END: Profile Info... --}}
@endsection

@section('content')
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

      @foreach ($gateways as $gateway)
          <div class="col-md-4">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <h4 class="text-center" style="text-transform:uppercase;color:white;margin-top:10px;">{{$gateway->name}}</h4>
                  </div>
                  <div class="panel-body">
                      <img src="{{asset('assets/users/img/gateway/' . $gateway->gateimg)}}" alt="">
                  </div>
                  <div class="panel-footer">
                      <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#amountModal{{$gateway->id}}">Select</button>
                  </div>
              </div>
          </div>
          <!-- Modal -->
          <div id="amountModal{{$gateway->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Add Fund</h4>
                      </div>
                      <div class="modal-body">
                          <form id="depositFormId" class="" method="post" action="{{route('depositPreview')}}">
                              {{csrf_field()}}
                              <input type="hidden" name="gateway" value="{{$gateway->id}}">
                              <input type="hidden" name="minamo" value="{{$gateway->minamo}}">
                              <input type="hidden" name="maxamo" value="{{$gateway->maxamo}}">
                              <div class="form-group">
                                  <label for="usr">Amount you want to add to your account:</label>
                                  <div class="input-group">
                                    <input type="text" name="amount" class="form-control" placeholder="">
                                    <span class="input-group-addon">{{$gs->base_curr_text}}</span>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <input class="btn btn-primary btn-block" type="submit" name="" value="Preview">
                              </div>
                          </form>
                          <script>

                          </script>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                  </div>

              </div>
          </div>
      @endforeach
  </div>


  {{-- <script>
      function deposit(e) {
        e.preventDefault();
        var depositForm = document.getElementById('depositFormId');
        var fd = new FormData(depositForm);
        $.ajax({
          url: '{{route('deposit')}}',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function() {
            // console.log(data);
          }
        });
      }
  </script> --}}
@endsection
