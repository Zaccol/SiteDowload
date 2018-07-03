@extends('users.layout.master')

@section('title', 'Seller to buyer message')

@section('meta-ajax')
  <meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <meta name="_token" content="{{ csrf_token() }}" /> --}}
@endsection

@push('styles')
  <style media="screen">

  </style>
@endpush


<style media="screen">
.chat-box-container {
  border:1px solid #d5d5d5;
  height: 500px;
  overflow-y:scroll;
  overflow-x: hidden;
  position:relative;
}
.buyer-message {
  float: left;
  background-color: #c6e2ff;
  border-radius:10px;
  color:black;
  padding:20px;
  max-width:480px;
}
.seller-message {
  background-color: #4080ff;
  border-radius:10px;
  color:white;
  padding:20px;
  max-width:480px;
}
#acceptRejectProject {
  padding: 10px 50px;
  /* position: absolute; */
  position:absolute;
  top:0px;
  left:0px;
  right:0px;
  /* z-index: 1; */
}
#acceptRejectProject i, .delivery-icons {
  padding:10px;
  border-radius:50%;
  font-size: 20px;
  cursor: pointer;
}
.all-messages {
  padding:20px 30px;
  position: relative;

}
</style>

@section('content')
	<div id="app">
    <div id="ChatBoxScrollableDivContainer">
      <div class="" style="padding:20px 40px;">
        <div id="chatBoxContainer" class="row chat-box-container">
          {{-- if order is accpeted or rejected, 'accept/reject' div will be disappeared... --}}
          @if ($orderStatus == 0)
            <div id="acceptRejectProject" class="row bg-primary">
              <div class="col-xs-6">
                <i onclick="acceptProject({{$orderID}})" style="background-color:green;" class="fa fa-check pull-left" aria-hidden="true"></i>
                <span class="pull-left" style="margin-top:10px;">Accept Project</span>
              </div>
              <div class="col-xs-6">
                <i onclick="rejecetProject({{$orderID}})" style="background-color:red;" class="fa fa-close pull-right"></i>
                <span class="pull-right" style="margin-top:10px;">Reject Project</span>
              </div>
            </div>
          @endif

          {{-- All messages --}}
          <div id="allMessages" class="row all-messages" style="{{($orderStatus == 0) ? 'top:50px;' : 'top:0px;'}}">
            @foreach ($uoms as $uom)
            @continue($uom->message_type == 'introToBuyer')

            {{-- Buyer Messages... --}}
            @if ($uom->type=='buyer')
            <div class="" style="float:left;">
              <img src="{{asset('assets/users/propics/'.$uom->user->pro_pic)}}" alt="" width="60" style="float:left;margin-right: 10px;border-radius: 50%;">
              <div class="buyer-message" style="">
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
                  <a download="{{$uom->original_file_name}}" target="_blank" style="color:black;text-decoration:underline;" href="{{asset('assets/users/buyer_message_files/'.$uom->file_name)}}">{{$uom->original_file_name}}</a>
                  <br>
                  {{-- if it is a image file then show the perview... --}}
                  @if ($png!=false ||  $jpg!= false ||  $jpeg!=false || $gif!=false)
                    <img src="{{asset('assets/users/buyer_message_files/'.$uom->file_name)}}" alt="" width="150">
                  @endif
                @endif
              </div>
            </div>
            <p style="clear:both;"></p>
            @endif


            {{-- Seller Messages... --}}
            @if ($uom->type=='seller')
            <div style="float:right;">
              <div class="seller-message">
                {{-- show the delivered product --}}
                @if ($uom->message_type == 'delivery')
                  <a download="{{$uom->original_file_name}}" target="_blank" style="color:white;text-decoration:underline;" href="{{asset('assets/users/seller_messages_files/'.$uom->file_name)}}">{{$uom->original_file_name}}</a>
                  <br>
                  <i class="fa fa-check" aria-hidden="true"></i> <small style="color:white;">Awating acceptance...</small>
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
                    $png = strpos($uom->original_file_name, 'png');
                    $jpg = strpos($uom->original_file_name, 'jpg');
                    $jpeg = strpos($uom->original_file_name, 'jpeg');
                    $gif = strpos($uom->original_file_name, 'gif');
                  @endphp
                  <a download="{{$uom->original_file_name}}" target="_blank" style="color:white;text-decoration:underline;" href="{{asset('assets/users/seller_messages_files/'.$uom->file_name)}}">{{$uom->original_file_name}}</a>
                  <br>
                  {{-- if it is a image file then show the perview... --}}
                  @if ($png!=false ||  $jpg!= false ||  $jpeg!=false || $gif!=false)
                    <img src="{{asset('assets/users/seller_messages_files/'.$uom->file_name)}}" alt="" width="150">
                  @endif
                @endif
              </div>
            </div>
            <p style="clear:both;"></p>
            @endif

            {{-- if seller has accepted this project then show this message... --}}
            @if ($uom->message_type == 'taken')
            <small class="bg-warning" style="color:black;display:block;margin:auto;width:260px;padding:20px;">You have {{$uom->user_message}}</small>
            <p style="clear:both;"></p>
            @endif

            {{-- if seller has accepted this project then show the maximum days to complete the project... --}}
            @if ($uom->message_type == 'delivery_date')
            <small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;"><strong>{{$uom->user_message}}</strong></small>
            <p style="clear:both;"></p>
            @endif

  					{{-- if buyer has accepted this delivery then show the message... --}}
  					@if ($uom->message_type == 'acceptedDelivery')
  					<small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">{{$buyerFirstName}} {{$buyerLastName}} have {{$uom->user_message}}</small>
  					<p style="clear:both;"></p>
  					@endif

  					{{-- if buyer has accepted this delivery then show the message... --}}
  					@if ($uom->message_type == 'rejectedDelivery')
  					<div class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">
  						{{$buyerFirstName}} {{$buyerLastName}} have {{$uom->user_message}}<br>
  						@if (empty($uom->deliveryRevision->revision_status))
  							<div id="revisionDecision">
  								<strong>Will you give a revision?</strong>
  								<i style="background-color:green;color:white;" class="fa fa-check pull-left delivery-icons" onclick="revisionAccepted({{$uom->order_id}}, {{$uom->id}})" aria-hidden="true"></i>
  								<span style="color:black;margin-top:10px;" class="pull-left">Yes</span>
  								<span style="color:black;margin-top:10px;" class="pull-right">No</span>
  								<i onclick="revisionRejected({{$orderID}}, {{$uom->id}})" style="background-color:red;color:white" class="fa fa-close pull-right delivery-icons"></i>
  							</div>
  						@endif
  						<p style="clear:both;"></p>
  					</div><br>
  					@endif

  					{{-- if seller has not taken this project then show the message... --}}
  					@if ($uom->message_type == 'notTaken')
  					<small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">You have {{$uom->user_message}}</small>
  					<p style="clear:both;"></p>
  					@endif

  					{{-- if seller is agreed to give a revision then show the message... --}}
  					@if ($uom->message_type == 'revisionAccepted')
  					<small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">You are {{$uom->user_message}}</small>
  					<p style="clear:both;"></p>
  					@endif

  					{{-- if seller has denied to give a revision then show the message... --}}
  					@if ($uom->message_type == 'revisionRejected')
  					<small class="bg-warning text-center" style="color:black;display:block;margin:auto;width:260px;padding:20px;">You have {{$uom->user_message}}</small>
  					<p style="clear:both;"></p>
  					@endif
            @endforeach
          </div>
        </div>
      </div>
    </div>

      <br>
      <div class="row" style="padding:0px 40px;">
        <form id="sellerToBuyerMessagesFormId" class="" method="post" onsubmit="submitSellerMessage(event)">
          {{csrf_field()}}
          <div class="form-group">
            <textarea class="form-control" name="message" rows="5" cols="80" placeholder="Write your message here..."></textarea>
          </div>
          <input type="hidden" name="orderID" value="{{$orderID}}">
          <div class="row">
            <div class="col-md-10" style="">
              <input title="check this before send attachments if you want to submit project" type="checkbox" name="delivery" value="requirement"> Deliver Project
              <label class="btn btn-outline-success" style="cursor:pointer;"><input onchange="submitSellerMessage(event)" id="achImage" name="attachment" style="display:none;" type="file" /><i class="fa fa-paperclip" aria-hidden="true" style="font-size:20px;"></i></label>
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-success pull-right" name="" value="send">
            </div>
          </div>
        </form>
        <strong id="attachmentTypeErr" style="color:red;"></strong>
      </div>

      @component('users.components.success')
      @endcomponent
	</div>
  <script src="{{asset('core/public/js/app.js')}}"></script>
@endsection

{{-- seller message submit... --}}
@push('scripts')
  <script>
    window.onload = function () {
      var elem = document.getElementById('chatBoxContainer');
      elem.scrollTop = elem.scrollHeight;
    }

    function submitSellerMessage(e) {
      e.preventDefault();
      var form = document.getElementById("sellerToBuyerMessagesFormId");
      var fd = new FormData(form);
      $.ajax({
        url: '{{route('seller.messageStore')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          console.log(data);

          // after returning from the controller we are clearing the
          // previous error messages...
          document.getElementById('attachmentTypeErr').innerHTML = '';

          if (data == "success") {
            form.reset();
            $("#ChatBoxScrollableDivContainer").load(location.href + " #ChatBoxScrollableDivContainer", function() {
              var elem = document.getElementById('chatBoxContainer');
              elem.scrollTop = elem.scrollHeight;
            });
            // $.get('/freelancing-site/event');
            $.get('{{route('chatEvent')}}');
          }
          // Showing error messages in the HTML...
          if(typeof data.error != 'undefined') {
            form.reset();
            if(typeof data.attachmentType != 'undefined') {
              document.getElementById('attachmentTypeErr').innerHTML = data.attachmentType[0];
            }
          }
        }
      });
    }
  </script>
@endpush

@push('scripts')
	{{-- accept project function --}}
	<script>
	    function acceptProject(orderID) {
	      var fd = new FormData();
	      fd.append('orderID', orderID);
	      $.ajaxSetup({
	          headers: {
	              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	          }
	      });
	      if(confirm('Are you sure, you want to reject this project?')) {
	        $.ajax({
	          url: '{{route('seller.acceptProject')}}',
	          type: 'POST',
	          data: fd,
	          contentType: false,
	          processData: false,
	          success: function(data) {
	            console.log(data);
	            if (data == "success") {
	              var snackbarSuccess = document.getElementById('snackbarSuccess');
	              snackbarSuccess.innerHTML = 'Order is accepted!';
	              snackbarSuccess.className = "show";
	              setTimeout(function() {
	                snackbarSuccess.className = snackbarSuccess.className.replace("show", "");
	              }, 3000);
	              $("#ChatBoxScrollableDivContainer").load(location.href + " #ChatBoxScrollableDivContainer", function() {
	                // $('#acceptRejectProject').remove();
                  // document.getElementById('allMessages').style.top = '0px';
	                var elem = document.getElementById('chatBoxContainer');
	                elem.scrollTop = elem.scrollHeight;
                  // firing event using pusher...
                  // $.get('/freelancing-site/event');
                  $.get('{{route('chatEvent')}}');
	              });
	            }
	          }
	        });
	      }
	    }
	</script>
@endpush

@push('scripts')
	<script>
		function rejecetProject(orderID) {
			var fd = new FormData();
			fd.append('orderID', orderID);
			$.ajaxSetup({
					headers: {
							'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
					}
			});
			var c = confirm("Are you sure, you want to rejecet this project?");
			if(c == true) {
				console.log(orderID);
				$.ajax({
					url: '{{route('seller.rejectProject')}}',
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,
					success: function(data) {
						console.log(data);
						if(data == "success") {
							var snackbarSuccess = document.getElementById('snackbarSuccess');
							snackbarSuccess.innerHTML = 'Order is rejected!';
							snackbarSuccess.className = "show";
							setTimeout(function() {
								snackbarSuccess.className = snackbarSuccess.className.replace("show", "");
							}, 3000);
							$("#ChatBoxScrollableDivContainer").load(location.href + " #ChatBoxScrollableDivContainer", function() {
								// $('#acceptRejectProject').remove();
                // document.getElementById('allMessages').style.top = '0px';
								var elem = document.getElementById('chatBoxContainer');
								elem.scrollTop = elem.scrollHeight;
                // firing event using pusher...
                // $.get('/freelancing-site/event');
                $.get('{{route('chatEvent')}}');
							});
						}
					}
				});
			}
		}
	</script>
@endpush

{{-- Revsion acceptance AJAX Request... --}}
@push('scripts')
	<script>
		function revisionAccepted(orderID, uomID) {
			var fd = new FormData();
			fd.append('orderID', orderID);
			fd.append('uomID', uomID);
			$.ajaxSetup({
					headers: {
							'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
					}
			});
			if (confirm('Are you sure, you want to give a revision?')) {
				$.ajax({
					url: '{{route('seller.revisionAccepted')}}',
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,
					success: function(data) {
						console.log(data);
						if(data == "success") {
							document.getElementById('revisionDecision').style.display = 'none';
							$("#ChatBoxScrollableDivContainer").load(location.href + " #ChatBoxScrollableDivContainer", function() {
								var elem = document.getElementById('chatBoxContainer');
								elem.scrollTop = elem.scrollHeight;
                // firing event using pusher...
                // $.get('/freelancing-site/event');
                $.get('{{route('chatEvent')}}');
							});
						}
					}
				});
			}
		}
	</script>
@endpush

{{-- Revision rejection AJAX request... --}}
@push('scripts')
	<script>
		function revisionRejected(orderID, uomID) {
			var fd = new FormData();
			fd.append('orderID', orderID);
			fd.append('uomID', uomID);
			$.ajaxSetup({
					headers: {
							'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
					}
			});
			if (confirm('Are you sure, you will reject this revision?')) {
				$.ajax({
					url: '{{route('seller.revisionRejected')}}',
					type: 'POST',
					data: fd,
					contentType: false,
					processData: false,
					success: function(data) {
						console.log(data);
						if(data == "success") {
							document.getElementById('revisionDecision').style.display = 'none';
							$("#ChatBoxScrollableDivContainer").load(location.href + " #ChatBoxScrollableDivContainer", function() {
								var elem = document.getElementById('chatBoxContainer');
								elem.scrollTop = elem.scrollHeight;
                // firing event using pusher...
                // $.get('/freelancing-site/event');
                $.get('{{route('chatEvent')}}');
							});
						}
					}
				});
			}
		}
	</script>
@endpush
