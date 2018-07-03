@extends('users.layout.master')

@section('content')

  <style>
  .credit-card-box .form-control.error {
  	border-color: red;
  	outline: 0;
  	box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(255,0,0,0.6);
  }
  .credit-card-box label.error {
  	font-weight: bold;
  	color: red;
  	padding: 2px 8px;
  	margin-top: 2px;
  }
  </style>
  <div class="col-xs-12 col-md-8 col-md-offset-2">
  	<div class="well">
  		<h1 class="text-center">Paiement</h1>
  		<hr/>
  		<form role="form" id="payment-form" method="POST" action="{{ route('ipn.stripe')}}">
  			{{csrf_field()}}
  			<div class="row">
  				<div class="col-xs-12">
  					<div class="form-group">
  						<label for="cardNumber">Numero de carte</label>
  						<div class="input-group">
  							<input
  							type="tel"
  							class="form-control input-lg"
  							name="cardNumber"
  							placeholder="Numero de carte valide"
  							autocomplete="off"
  							required autofocus
  							/>
  							<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
  						</div>
  					</div>
  				</div>
  			</div>
  			<br>

  			<div class="row">
  				<div class="col-xs-7 col-md-7">
  					<div class="form-group">
  						<label for="cardExpiry">Date d'expiration</label>
  						<input
  						type="tel"
  						class="form-control input-lg input-sz"
  						name="cardExpiry"
  						placeholder="MM / YYYY"
  						autocomplete="off"
  						required
  						/>
  					</div>
  				</div>
  				<div class="col-xs-5 col-md-5 pull-right">
  					<div class="form-group">
  						<label for="cardCVC">Code secret</label>
  						<input
  						type="tel"
  						class="form-control input-lg input-sz"
  						name="cardCVC"
  						placeholder="code secret"
  						autocomplete="off"
  						required
  						/>
  					</div>
  				</div>
  			</div>

  			<br>

  			<div class="row">
  				<div class="col-xs-12">
  					<button class="btn btn-success btn-lg btn-block" type="submit"> PAYER </button>
  				</div>
  			</div>

  		</form>

  	</div>

  </div>

  <script type="text/javascript" src="{{ asset('assets/users/stripe/payvalid.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/users/stripe/paymin.js') }}"></script>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script type="text/javascript" src="{{ asset('assets/users/stripe/payform.js') }}"></script>
@endsection
