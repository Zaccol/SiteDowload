
@extends('admin.layout.master')

@section('body')
    
        
 
<div class="page-content-wrapper">
<div class="page-content">

<h3 class="page-title uppercase bold"> {{$data['page_title']}}
</h3>
<hr>



<div class="row">

	<div class="col-md-4">
		<strong>NAME</strong>
		<input type="text" class="form-control input-lg" value="{{$user->name}}">
	</div>
	
	<div class="col-md-4">
		<strong>EMAIL</strong>
		<input type="text" class="form-control input-lg" value="{{$user->email}}">
	</div>
	
	<div class="col-md-4">
		<strong>MAC ID</strong>
		<input type="text" class="form-control input-lg" value="{{$user->mac}}">
	</div>

	<div class="col-md-4">
		<strong>MOBILE</strong>
		<input type="text" class="form-control input-lg" value="{{$user->mobile}}">
	</div>
	
	<div class="col-md-4">
		<strong>ADDRESS</strong>
		<input type="text" class="form-control input-lg" value="{{$user->address}}">
	</div>	
	<div class="col-md-4">
		<strong>BALANCE</strong>
		<input type="text" class="form-control input-lg" value="{{$user->balance}}">
	</div>

</div>



<h1 class="text-center">TRANSACTION</h1>

WILL VISIBLE HERE















</div>
</div>      











@endsection
