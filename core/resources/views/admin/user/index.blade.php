
@extends('admin.layout.master')

@section('body')
    
        
 
<div class="page-content-wrapper">
<div class="page-content">

<h3 class="page-title uppercase bold"> {{$data['page_title']}}
</h3>
<hr>










<div class="portlet light bordered">
<div class="portlet-title">
<div class="caption font-dark">
<i class="icon-settings font-dark"></i>
<span class="caption-subject bold uppercase">MAC ID LIST</span>
</div>
<div class="tools"> </div>
</div>
<div class="portlet-body">
<table class="table table-striped table-bordered table-hover" id="sample_1">
<thead>
<tr>
<th>NAME</th>
<th>EMAIL</th>
<th>MAC</th>
<th>DETAILS</th>
</tr>
</thead>

<tbody>

@foreach($users as $user)
<tr>
<td>{{$user->name}}</td>
<td>{{$user->email}}</td>
<td>{{$user->mac}}</td>
<td>

<a href="{{route('user.details', $user->id)}}" class="btn btn-success btn-md">DETAILS</a>

</td>
</tr>
@endforeach

</tbody>
</table>
</div>
</div>























</div>
</div>      










<!-- Modal for Edit button -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="myModalLabel"> <b class="abir_act"></b> MAC ID</h4>
</div>
<form method="post" action="{{route('update.mac')}}">
          {{ csrf_field() }}
<div class="modal-body">
<div class="form-group">


<input class="form-control abir_id" type="hidden" name="id">
<input class="form-control input-lg abir_name" name="macid" placeholder="MAC ID" required>
<br>



</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
</div>
</div>



@endsection
