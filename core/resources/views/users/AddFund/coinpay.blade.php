@extends('users.layout.master')

@section('content')
<div class="row">
<div class="col-md-12">
<div class="panel panel-inverse">
	<div class="panel-heading">
		<h3 class="panel-title">Confirm Buy</h3>
	</div>
	<div class="panel-body">

		<div  class="col-md-8 col-md-offset-2 text-center">

			<h1>{{$gs->base_curr_symbol}} {{$amount}} 
					<i class="fa fa-exchange"></i> <i class="fa fa-bitcoin"></i>{{ $bcoin }}</h1>

		<b style="color: red;"> Minimum 3 Confirmation Required to Credited Your Account.<br/>(It May Take Upto 2 to 24 Hours)</b>
		<br/>
		<p>{!! $form !!}</p>
		</div>


	</div>
</div>
</div>
</div>

@endsection
