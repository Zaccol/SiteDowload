@extends('admin.layout.master')

@section('body')
<div class="page-content-wrapper">
   <div class="page-content" style="min-height:536px">
      <h3 class="page-title uppercase bold"> <i class="fa fa-desktop"></i> Withdraw Log</h3>
      <hr>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box blue">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-list"></i>  Withdraw Log
                  </div>
                  <div class="actions">
                     PAGE {{$data['withdraws']->currentPage()}} OF {{$data['withdraws']->lastPage()}}
                  </div>
               </div>
               <div class="portlet-body">
                 @if (count($data['withdraws']) == 0)
                   <h1>NO DATA FOUND!</h1>
                 @else
                   <div class="table-scrollable">
                      <table class="table table-bordered table-hover">
                         <thead>
                            <tr>
                               <th> # </th>
                               <th> METHOD </th>
                               <th> USER </th>
                               <th> AMOUNT </th>
                               <th> CHARGE </th>
                               <th> TIME </th>
                               <th> TRX # </th>
                               <th> STATUS</th>
                               <th> DETAILS </th>
                            </tr>
                         </thead>
                         <tbody>
                           @php
                             $i = 0;
                           @endphp
                           @foreach ($data['withdraws'] as $withdraw)
                           <tr class="warning">
                              <td> {{++$i}} </td>
                              <td> {{$withdraw->withdrawMethod->name}} </td>
                              <td>{{$withdraw->user->username}}</td>
                              <td class="bold"> {{$withdraw->amount}} {{$gs->base_curr_text}} </td>
                              <td> {{$withdraw->charge}} {{$gs->base_curr_text}} </td>
                              <td> {{$withdraw->created_at->format('l jS \\of F Y h:i:s A')}}  </td>
                              <td> {{$withdraw->trx}} </td>
                              <td> {{$withdraw->status}} </td>
                              <td> <a target="_blank" href="{{route('withdrawLog.show', $withdraw->id)}}" class="btn btn-primary"> <i class="fa fa-desktop"></i> DETAILS </a> </td>
                           </tr>
                           @endforeach
                         </tbody>
                      </table>
                   </div>
                 @endif

                  <!-- print pagination -->
                  <div class="row">
                     <div class="text-center">
                        {{$data['withdraws']->links()}}
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
