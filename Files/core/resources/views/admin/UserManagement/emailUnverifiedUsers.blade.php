@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:394px">
        <h3 class="page-title uppercase bold"> <i class="fa fa-desktop"></i> View EMAIL UNVERIFIED USERS</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <div class="portlet box yellow">
                 <div class="portlet-title">
                    <div class="caption">
                       <i class="fa fa-list"></i>  EMAIL UNVERIFIED USERS LIST
                    </div>
                    <div class="actions">
                       PAGE {{$emailUnverifiedUsers->currentPage()}} OF {{$emailUnverifiedUsers->lastPage()}}
                    </div>
                 </div>
                 @if (count($emailUnverifiedUsers)==0)
                 <div class="portlet-body">
                    <h1 class="text-center"> NO RESULT FOUND !</h1>
                    <!-- print pagination -->
                    <div class="row">
                       <div class="text-center">
                          <ul class="pagination">
                          </ul>
                       </div>
                    </div>
                    <!-- row -->
                    <!-- END print pagination -->
                 </div>
                 @else
                 <div class="portlet-body">
                    <div class="table-scrollable">
                       <table class="table table-bordered table-hover">
                          <thead>
                             <tr>
                                <th> # </th>
                                <th> NAME </th>
                                <th> EMAIL </th>
                                <th> MOBILE </th>
                                <th> BALANCE </th>
                                <th> DETAILS </th>
                             </tr>
                          </thead>
                          <tbody>
                            @php
                              $i=0;
                            @endphp
                            @foreach ($emailUnverifiedUsers as $emailUnverifiedUser)
                            <tr class="bold">
                               <td> {{++$i}} </td>
                               <td> {{$emailUnverifiedUser->username}}  </td>
                               <td> {{$emailUnverifiedUser->email}} </td>
                               <td> {{$emailUnverifiedUser->phone}} </td>
                               <td> {{$emailUnverifiedUser->balance}} USD </td>
                               <td><a href="http://idealbrothers.thesoftking.com/walletv2/admin/UserDetails/837" class="btn btn-success btn-md">
                                  <i class="fa fa-desktop"></i> VIEW DETAILS</a>
                               </td>
                            </tr>
                            @endforeach
                          </tbody>
                       </table>
                    </div>
                    <!-- print pagination -->
                    <div class="row">
                       <div class="text-center">
                          {{$emailUnverifiedUsers->links()}}
                       </div>
                    </div>
                    <!-- row -->
                    <!-- END print pagination -->
                 </div>
                 @endif
              </div>
           </div>
        </div>
        <!-- ROW-->
     </div>
  </div>
@endsection
