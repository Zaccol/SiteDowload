@extends('admin.layout.master')

@section('body')
<div class="page-content-wrapper">
   <div class="page-content" style="min-height:361px">
      <h3 class="page-title uppercase bold"> <i class="fa fa-desktop"></i> Withdraw Log - Success</h3>
      <hr>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box green">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-list"></i>  Withdraw Log - Success
                  </div>
                  <div class="actions">
                     PAGE {{$withdraws->currentPage()}} OF {{$withdraws->lastPage()}}
                  </div>
               </div>
               <div class="portlet-body">
                 @if (count($withdraws) == 0)
                   <h1 class="text-center"> NO RESULT FOUND !</h1>
                 @else
                 <table class="table table-bordered" style="width:100%;">
                   <thead>
                     <tr>
                       <th>#</th>
                       <th>METHOD</th>
                       <th>USER</th>
                       <th>AMOUNT</th>
                       <th>CHARGE</th>
                       <th>TIME</th>
                       <th>TRX #</th>
                       <th>STATUS</th>
                       <th>DETAILS</th>
                     </tr>
                   </thead>
                   <tbody>
                     @php
                       $i = 0;
                     @endphp
                     @foreach ($withdraws as $withdraw)
                     <tr>
                       <td>{{++$i}}</td>
                       <td>{{$withdraw->withdrawMethod->name}}</td>
                       <td>{{$withdraw->user->username}}</td>
                       <td>{{$withdraw->amount}}  {{$gs->base_curr_text}}</td>
                       <td>{{$withdraw->charge}}  {{$gs->base_curr_text}}</td>
                       <td>{{$withdraw->created_at->format('l jS \\of F Y h:i:s A')}}</td>
                       <td>{{$withdraw->trx}}</td>
                       <td>{{$withdraw->status}}</td>
                       <td>
                         <a target="_blank" class="btn btn-warning" href="{{route('withdrawLog.show', $withdraw->id)}}">Details</a>
                       </td>
                     </tr>
                     @endforeach
                   </tbody>
                 </table>
                 @endif

                  <!-- print pagination -->
                  <div class="row">
                     <div class="text-center">
                        {{$withdraws->links()}}
                     </div>
                  </div>
                  <!-- row -->
                  <!-- END print pagination -->
               </div>
            </div>
         </div>
      </div>
      <!-- ROW-->
   </div>
</div>
@endsection
