@extends('admin.layout.master')

@section('body')
<div class="page-content-wrapper">
   <div class="page-content" style="min-height:536px">
      <h3 class="page-title uppercase bold"> <i class="fa fa-desktop"></i> Deposit Log</h3>
      <hr>
      <div class="row">
         <div class="col-md-12">
            <div class="portlet box blue">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-list"></i>  Deposit Log
                  </div>
                  <div class="actions">
                     PAGE {{$data['deposits']->currentPage()}} OF {{$data['deposits']->lastPage()}}
                  </div>
               </div>
               <div class="portlet-body">
                 @if (count($data['deposits']) == 0)
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
                               <th> STATUS</th>
                            </tr>
                         </thead>
                         <tbody>
                           @php
                             $i = 0;
                           @endphp
                           @foreach ($data['deposits'] as $deposit)
                           <tr class="warning">
                              <td> {{++$i}} </td>
                              <td> {{$deposit->gateway->name}} </td>
                              <td>{{$deposit->user->username}}</td>
                              <td class="bold"> {{$deposit->amount}} {{$gs->base_curr_text}} </td>
                              <td class="bold"> {{($deposit->amount - $deposit->wc_amount)}} {{$gs->base_curr_text}} </td>
                              <td> {{$deposit->created_at->format('l jS \\of F Y h:i:s A')}}  </td>
                              <td> {{$deposit->status == 0? 'incomplete' : 'complete'}} </td>
                           </tr>
                           @endforeach
                         </tbody>
                      </table>
                   </div>
                 @endif

                  <!-- print pagination -->
                  <div class="row">
                     <div class="text-center">
                        {{$data['deposits']->links()}}
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
