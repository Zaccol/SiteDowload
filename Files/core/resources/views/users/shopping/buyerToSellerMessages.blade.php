@extends('users.layout.master')

@section('meta-ajax')
  <meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <meta name="_token" content="{{ csrf_token() }}" /> --}}
@endsection

@push('styles')
  <style media="screen">
    .delivery-icons {
      padding:10px;
      border-radius:50%;
      font-size: 20px;
      cursor: pointer;
    }
  </style>
@endpush

@section('title', 'Buyer to Seller Message')

@section('content')
  <div id="app">
    <div class="" style="padding:10px 40px;">
      <div id="AllMessagesContainer">
        <div id="AllMessages" style="border:1px solid #d5d5d5;height: 500px;overflow-y:scroll;padding:20px 20px">

          @foreach ($uoms as $uom)
            @if ($uom->type=='seller')
            <div class="" style="float:left;">
              <img src="{{asset('assets/users/propics/'.$uom->user->pro_pic)}}" alt="" width="60" style="float:left;margin-right: 10px;border-radius: 50%;">
              <div style="float: left;background-color: {{($uom->message_type != 'delivery')? '#c6e2ff' : '#ffc107'}};border-radius:10px;color:black;padding:20px;max-width:480px;">
                <div>
                  @if ($uom->message_type == 'introToBuyer')
                  {!! $uom->user_message !!}
                  {{-- closing all the divs required as we have to continue the loop without closing the divs --}}
                  </div>
                  </div>
                  </div>
                  <p style="clear:both;"></p>
                  @continue
                  @endif
                  @if ($uom->message_type == 'delivery')
                  <a download="{{$uom->original_file_name}}" target="_blank" style="color:black;text-decoration:underline;" href="{{asset('assets/users/seller_messages_files/'.$uom->file_name)}}">{{$uom->original_file_name}}</a>
                  <p style="clear:both;"></p>
  								@if (empty($uom->deliveryAcceptance->acceptance_status))
  								<div id="deliveryAcceptanceDecision">
  									<i style="background-color:green;color:white" class="fa fa-check pull-left delivery-icons" onclick="showReviewModal({{$uom->order_id}}, {{$uom->id}})" aria-hidden="true"></i>
  									<span style="color:black;margin-top:10px;" class="pull-left">Accept Delivery</span>
  									<span style="color:black;margin-top:10px;" class="pull-right">Reject Delivery</span>
  									<i onclick="rejectDelivery({{$orderID}}, {{$uom->id}})" style="background-color:red;color:white" class="fa fa-close pull-right delivery-icons"></i>
  								</div>
  								@endif
                  </div>
                  </div>
                  </div>
                  <p style="clear:both;"></p>
                  @continue
                  @endif
                  {{-- check if this row contains text message... --}}
                  @if (!empty($uom->user_message))
                  {{$uom->user_message}}
                  @endif
                  {{-- check if this database row contains a file... --}}
                  @if (!empty($uom->original_file_name))
                  @php
                  $png = strpos($uom->original_file_name, '.png');
                  $jpg = strpos($uom->original_file_name, '.jpg');
                  $jpeg = strpos($uom->original_file_name, '.jpeg');
                  $gif = strpos($uom->original_file_name, '.gif');
                  @endphp
                  <a download="{{$uom->original_file_name}}" target="_blank" style="color:black;text-decoration:underline;" href="{{asset('assets/users/seller_messages_files/'.$uom->file_name)}}">{{$uom->original_file_name}}</a>
                  <br>
                  {{-- if it is a image file then show the perview... --}}
                  @if ($png!=false ||  $jpg!= false ||  $jpeg!=false || $gif!=false)
                  <img src="{{asset('assets/users/seller_messages_files/'.$uom->file_name)}}" alt="" width="150">
                  @endif
                  @endif
                </div>
              </div>
              <p style="clear:both;"></p>
            </div>
            <p style="clear:both;"></p>
            @endif
            @if ($uom->type=='buyer')
            <div style="float:right;">
              <div style="background-color: #4080ff;border-radius:10px;color:white;padding:20px;max-width:480px;">
                {{-- check if this row contains text message... --}}
                @if (!empty($uom->user_message))
                  {{$uom->user_message}}
                @endif
                {{-- check if this database row contains a file... --}}
                @if (!empty($uom->original_file_name))
                  @php
                    $png = strpos($uom->original_file_name, 'png');
                    $jpg = strpos($uom->original_file_name, 'jpg');
                    $jpeg = strpos($uom->original_file_name, 'jpeg');
                    $gif = strpos($uom->original_file_name, 'gif');
                  @endphp
                  <a download="{{$uom->original_file_name}}" style="color:white;text-decoration:underline;" href="{{asset('assets/users/buyer_message_files/'.$uom->file_name)}}">{{$uom->original_file_name}}</a>
                  <br>
                  @if ($png!=false ||  $jpg!= false ||  $jpeg!=false || $gif!=false)
                    <img src="{{asset('assets/users/buyer_message_files/'.$uom->file_name)}}" alt="" width="150">
                  @endif
                @endif
              </div>
            </div>
            <p style="clear:both;"></p>
            @endif

            {{-- if seller has accepted this project then show this message... --}}
            @if ($uom->message_type == 'taken')
            <small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;"><strong>{{$sellerFirstName . ' ' . $sellerLastName}}</strong> have {{$uom->user_message}}</small>
            <p style="clear:both;"></p>
            @endif

            {{-- if seller has accepted this project then show the maximum days to complete the project... --}}
            @if ($uom->message_type == 'delivery_date')
            <small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;"><strong>{{$uom->user_message}}</strong></small>
            <p style="clear:both;"></p>
            @endif

            {{-- if buyer has accepted this delivery then show the message... --}}
            @if ($uom->message_type == 'acceptedDelivery')
            <small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">You have {{$uom->user_message}}</small>
            <p style="clear:both;"></p>
            @endif

            {{-- if buyer has rejected this delivery then show the message... --}}
            @if ($uom->message_type == 'rejectedDelivery')
            <small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">You have {{$uom->user_message}}</small>
            <p style="clear:both;"></p>
            @endif

            {{-- if seller has not taken the project the show this message... --}}
            @if ($uom->message_type == 'notTaken')
            <small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">{{$sellerFirstName . ' ' . $sellerLastName}} has {{$uom->user_message}}</small>
            <p style="clear:both;"></p>
            @endif

            {{-- if seller is ready to give revision then show this message... --}}
            @if ($uom->message_type == 'revisionAccepted')
            <small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">{{$sellerFirstName . ' ' . $sellerLastName}} is {{$uom->user_message}}</small>
            <p style="clear:both;"></p>
            @endif

  					{{-- if seller has denied to give a revision then show the message... --}}
  					@if ($uom->message_type == 'revisionRejected')
  					<small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">{{$sellerFirstName . ' ' . $sellerLastName}} have {{$uom->user_message}}</small>
  					<p style="clear:both;"></p>
  					@endif
          @endforeach
        </div>
      </div>
      <br>
      <div class="row">
        <form id="buyerToSellerMessagesFormId" class="" method="post" onsubmit="submitBuyerMessage(event)">
          {{csrf_field()}}
          <div class="form-group">
            <textarea class="form-control" name="message" rows="5" cols="80" placeholder="Write your message here..."></textarea>
            <p class="error-messages-chat" id="messageError"></p>
          </div>
          <input type="hidden" name="orderID" value="{{$orderID}}">
          <div class="row">
            <div class="col-md-10">
              {{-- <input type="checkbox" name="requirement" value="requirement"> Requirements --}}
              <label class="btn btn-outline-success" style="cursor:pointer;"><input onchange="submitBuyerMessage(event)" id="achImage" name="attachment" style="display:none;" type="file" /><i class="fa fa-paperclip" aria-hidden="true" style="font-size:20px;"></i></label>
              <strong id="attachmentErr" style="color:red;"></strong>
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-success pull-right" name="" value="send">
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
  					<button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Review This Service</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-10 col-md-offset-1">
              <form class="" id="ratingForm">
                {{csrf_field()}}
  							<input type="hidden" name="uomID" id="uomID" value="">
                <div class="">
                  <label><input onclick="likeStatusChange(this.value)" type="radio" value="1" style="display:none;"><i id="likeIcon" style="cursor:pointer;font-size:20px;" class="fa fa-thumbs-up"></i></label> Like
                  <label style="margin-left:10px;"><input onclick="likeStatusChange(this.value)" type="radio" value="0" style="display:none;"><i id="dislikeIcon" style="cursor:pointer;font-size:20px;" class="fa fa-thumbs-down"></i></label> Dislike
                  <p class="error-messages text-danger"></p>
                </div><br>
                <div class="form-group">
                  <label for="">Leave a comment:</label>
                  <textarea name="ratingComment" rows="4" style="width:100%;" placeholder="Please give a review to the freelancer..."></textarea>
                  <p class="error-messages text-danger"></p>
                </div>
              </form>
            </div>
            <p style="clear:both;"></p>
          </div>
          <div class="modal-footer">
  					<button onclick="rateProject({{$orderID}})" class="btn btn-warning" type="button" name="button">Submit</button>
  					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    @component('users.components.success')
    @endcomponent

  </div>
  <script src="{{asset('core/public/js/app.js')}}"></script>
@endsection

@push('scripts')
  <script>
    function showReviewModal(orderID, uomID) {
      $("#reviewModal").modal('show');
			document.getElementById('uomID').value = uomID;
      console.log(orderID);
    }
  </script>

@endpush

@push('scripts')
  <script>
    window.onload = function () {
      var elem = document.getElementById('AllMessages');
      elem.scrollTop = elem.scrollHeight;
    }

    function submitBuyerMessage(e) {
      e.preventDefault();
      var form = document.getElementById("buyerToSellerMessagesFormId");
      var fd = new FormData(form);
      $.ajax({
        url: '{{route('buyer.messageStore')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);

          // after returning from the controller we are clearing the
          // previous error messages...
          document.getElementById('attachmentErr').innerHTML = '';

          if (data == "success") {
            form.reset();
            $("#AllMessagesContainer").load(location.href + " #AllMessagesContainer", function() {
              var elem = document.getElementById('AllMessages');
              elem.scrollTop = elem.scrollHeight;
              // firing event using pusher...
              // $.get('/freelancing-site/event');
              $.get('{{route('chatEvent')}}');
            });
          }
          // Showing error messages in the HTML...
          if(typeof data.error != 'undefined') {
            form.reset();
            if(typeof data.attachment != 'undefined') {
              document.getElementById('attachmentErr').innerHTML = data.attachment[0];
            }
          }
        }
      });
    }
  </script>
@endpush

@push('scripts')
  <script>
    var likeStatus;
    function likeStatusChange(val) {
      if(val == 1) {
        document.getElementById('dislikeIcon').style.color = 'black';
        document.getElementById('likeIcon').style.color = 'blue';
      } else {
        document.getElementById('likeIcon').style.color = 'black';
        document.getElementById('dislikeIcon').style.color = 'blue';
      }
      likeStatus = val;
      console.log(likeStatus);
    }

    function rateProject(orderID) {
      var form = document.getElementById('ratingForm');
      var fd = new FormData(form);
      fd.append('orderID', orderID);
      fd.append('likeStatus', likeStatus);
      $.ajaxSetup({
          headers: {
              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: '{{route('buyer.rateProject')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          var errorMessages = document.getElementsByClassName('error-messages');
          for(i=0; i<errorMessages.length; i++) {
            errorMessages[i].innerHTML = '';
          }
          console.log(data);
          if(data == "success") {
            $("#reviewModal").modal('hide');
            var snackbarSuccess = document.getElementById('snackbarSuccess');
            snackbarSuccess.innerHTML = "Freelancer has been rated successfully!";
            snackbarSuccess.className = "show";
            setTimeout(function() {
              snackbarSuccess.className = snackbarSuccess.className.replace("show", "");
            }, 3000);
            $("#AllMessagesContainer").load(location.href + " #AllMessagesContainer", function() {
							document.getElementById('deliveryAcceptanceDecision').style.display = 'none';
              var elem = document.getElementById('AllMessages');
              elem.scrollTop = elem.scrollHeight;
            });
            // firing event using pusher...
            // $.get('/freelancing-site/event');
            $.get('{{route('chatEvent')}}');
          }
          // Showing error message in the HTML...
          if(typeof data.error != 'undefined') {
            if(typeof data.likeStatus != 'undefined') {
              errorMessages[0].innerHTML = data.likeStatus[0];
            }
            if(typeof data.ratingComment != 'undefined') {
              errorMessages[1].innerHTML = data.ratingComment[0];
            }
          }
        }
      });
    }
  </script>
@endpush

{{-- Reject Delivery AJAX Request --}}
@push('scripts')
  <script>
    function rejectDelivery(orderID, uomID) {
      var fd = new FormData();
			fd.append('orderID', orderID);
      fd.append('uomID', uomID);
      $.ajaxSetup({
          headers: {
              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          }
      });
      if (confirm('Are you sure, you want to reject this delivery?')) {
        console.log(orderID);
        $.ajax({
          url: '{{route('buyer.rejectDelivery')}}',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            if(data == "success") {
              document.getElementById('deliveryAcceptanceDecision').style.display = 'none';
              $("#AllMessagesContainer").load(location.href + " #AllMessagesContainer", function() {
                var elem = document.getElementById('AllMessages');
                elem.scrollTop = elem.scrollHeight;
              });
              // firing event using pusher...
              // $.get('/freelancing-site/event');
              $.get('{{route('chatEvent')}}');
            }
          }
        });
      }
    }
  </script>
@endpush
