@extends('admin.layout.master')

@section('meta-ajax')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:394px">
        <h3 class="page-title uppercase bold"> <i class="fa fa-desktop"></i> View ALL Services</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <div class="portlet box blue">
                 <div class="portlet-title">
                    <div class="caption">
                       <i class="fa fa-list"></i>  ALL SERVICES LIST
                    </div>
                    <div class="actions">
                       PAGE {{$services->currentPage()}} OF {{$services->lastPage()}}
                    </div>
                 </div>
                 @if (count($services) == 0)
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
                                <th> Title </th>
                                <th> Description </th>
                                <th> Actions </th>
                             </tr>
                          </thead>
                          <tbody>
                              @php
                                $i=0;
                              @endphp
                             @foreach ($services as $service)
                             <tr class="bold">
                                <td> {{++$i}} </td>
                                <td> <h4 style="margin:0px;"><a class="title" href="{{route('services.show', [$service->id, $service->user->id])}}">{{strlen($service->service_title) > 20 ? substr($service->service_title, 0, 20) . '...' : $service->service_title}}</a></h4> </td>
                                <td> <p>{{ (strlen(strip_tags($service->description)) > 50) ? substr(strip_tags($service->description), 0, 50) . '...' : strip_tags($service->description) }}</p> </td>
                                <td>
                                  <button id="hideShowBtn{{$service->id}}" class="btn btn-danger" type="button" name="button" onclick="showHideGig(event,{{$service->id}})">{{$service->show==1?'Hide':'Show'}}</button>
                                  <button id="featureStatusBtn{{$service->id}}" class="btn btn-success" type="button" name="button" onclick="changeFeatureStatus(event,{{$service->id}})">{{$service->feature==1?'Unfeature':'Feature'}}</button>
                                </td>
                             </tr>
                             @endforeach
                          </tbody>
                       </table>
                    </div>
                    <!-- print pagination -->
                    <div class="row">
                       <div class="text-center">
                          {{$services->links()}}
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

@includeif('admin.gigManagement.partials.ajaxFunc')
