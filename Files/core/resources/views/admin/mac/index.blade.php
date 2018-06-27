
@extends('admin.layout.master')

@section('body')
    
        
 
<div class="page-content-wrapper">
<div class="page-content">

<h3 class="page-title uppercase bold"> {{$data['page_title']}}


<button type="button" class="btn btn-success btn-lg pull-right edit_button" 
data-toggle="modal" data-target="#myModal"
data-act="Add New"
data-name=""
data-id="0">
<i class="fa fa-plus"></i>  ADD NEW
</button> 


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
<th>MAC ID</th>
<th>STATUS</th>
<th>ACTION</th>
</tr>
</thead>

<tbody>

@foreach($macs as $mac)
<tr>
<td>{{$mac->macid}}</td>
<td>



<b class="btn btn-md btn-{{ $mac->status ==0 ? 'success' : 'warning' }}">{{ $mac->status == 0 ? 'ALAILABLE' : 'USED' }}</b>

</td>
<td>
<button type="button" class="btn purple btn-sm edit_button" 
data-toggle="modal" data-target="#myModal"
data-act="Edit"
data-name="{{$mac->macid}}"
data-id="{{$mac->id}}">
<i class="fa fa-edit"></i> EDIT
</button>

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





@section('script')


<script>
    $(document).ready(function(){
        
$(document).on( "click", '.edit_button',function(e) {

        var name = $(this).data('name');
        var id = $(this).data('id');
        var act = $(this).data('act');

        $(".abir_id").val(id);
        $(".abir_name").val(name);
        $(".abir_act").text(act);

    });


        
    });


</script>
@endsection