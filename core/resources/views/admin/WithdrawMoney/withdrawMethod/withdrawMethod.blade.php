@extends('admin.layout.master')

@section('meta-ajax')
  <meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <meta name="_token" content="{{ csrf_token() }}" /> --}}
@endsection


@section('body')
<div class="page-content-wrapper">
   <div class="page-content" style="min-height:536px">
      <h3 class="page-title  uppercase bold"> Withdraw Method Management
         <button type="button" class="btn btn-primary  btn-md pull-right edit_button" data-toggle="modal" data-target="#addModal" data-act="Add New" data-name="" data-id="0">
         <i class="fa fa-plus"></i>  ADD NEW
         </button>
      </h3>
      <hr>
      <div id="wmsContainerID">
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

         <div class="row">
            <div class="col-md-12">
               <!-- BEGIN EXAMPLE TABLE PORTLET-->
               <div class="portlet light bordered">
                  <div class="portlet-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Limit/Trx</th>
                          <th>Charge/Trx</th>
                          <th>Process Time</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['wms'] as $wm)
                        <tr>
                           <td>{{$wm->name}}</td>
                           <td><b>{{$wm->min_limit}} </b> TO <b>{{$wm->max_limit}} {{$gs->base_curr_text}}</b></td>
                           <td><b>{{$wm->fixed_charge}} </b> + <b>{{$wm->percentage_charge}} %</b></td>
                           <td><b>{{$wm->process_time}}</b></td>
                           <td>
                              <button type="button" class="btn purple btn-sm edit_button" data-toggle="modal" data-target="#myModal" data-act="Edit" data-ptm="2-4" data-cp="2" data-cd="1" data-max="10000" data-min="100" data-name="bKash" data-id="1" onclick="showEditModal({{$wm->id}})">
                              <i class="fa fa-edit"></i> EDIT
                              </button>
                              <button id="enableDisableBtnID{{$wm->id}}" type="button" class="btn btn-danger btn-sm delete_button" data-toggle="modal" data-target="#DelModal" data-id="1" onclick="enableDisableWM({{$wm->id}})">{{($wm->deleted==1)?'Enable':'Disable'}}</button>
                           </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>
         <!-- ROW-->
      </div>

   </div>
   <!-- END CONTENT BODY -->
</div>


{{-- Add Modal --}}
@includeIf('admin.WithdrawMoney.withdrawMethod.partials._add')

{{-- Delete Modal --}}
@includeIf('admin.WithdrawMoney.withdrawMethod.partials._delete')

{{-- Edit Modal --}}
@includeIf('admin.WithdrawMoney.withdrawMethod.partials._edit')
@endsection
