@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:394px">
        <h3 class="page-title uppercase bold"> <i class="fa fa-desktop"></i> View Banned USERS</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <div class="portlet box red">
                 <div class="portlet-title">
                    <div class="caption">
                       <i class="fa fa-list"></i>  BANNED USERS LIST
                    </div>
                    <div class="actions">
                       PAGE {{$bannedUsers->currentPage()}} OF {{$bannedUsers->lastPage()}}
                    </div>
                 </div>
                 @if (count($bannedUsers) == 0)
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
                                <th> COUNTRY </th>
                                <th> DETAILS </th>
                             </tr>
                          </thead>
                          <tbody>
                              @php
                                $i=0;
                              @endphp
                             @foreach ($bannedUsers as $bannedUser)
                             <tr class="bold">
                                <td> {{++$i}} </td>
                                <td> {{$bannedUser->username}} </td>
                                <td> {{$bannedUser->email}} </td>
                                <td> {{$bannedUser->phone}} </td>
                                <td> {{$bannedUser->balance}} USD </td>
                                <td> {{$bannedUser->country}} </td>
                                <td><a target="_blank" href="{{route('admin.userDetails', $bannedUser->id)}}" class="btn btn-success btn-md">
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
                          {{$bannedUsers->links()}}
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
