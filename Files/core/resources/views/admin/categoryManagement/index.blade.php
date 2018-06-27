@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:391px">
        <h3 class="page-title uppercase bold"> <i class="fa fa-desktop"></i> View ALL Categories</h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <div class="portlet box blue">
                 <div class="portlet-title">
                    <div class="caption">
                       <i class="fa fa-list"></i>  ALL CATEGORIES LIST
                    </div>
                    <div class="actions">
                         PAGE {{$categories->currentPage()}} OF {{$categories->lastPage()}}
                    </div>
                 </div>
                 <div class="portlet-body">
                   @if ($errors->any())
                       <div class="alert alert-danger">
                           <ul>
                               @foreach ($errors->all() as $error)
                                   <li>{{ $error }}</li>
                               @endforeach
                           </ul>
                       </div>
                   @endif
                    <button class="btn btn-primary pull-right" type="button" name="button" data-toggle="modal" data-target="#addModal">Add Category</button>
                    <br><br>
                    <div class="table-scrollable">
                       <table class="table table-bordered table-hover">
                          <thead>
                             <tr>
                                <th> # </th>
                                <th> Name </th>
                                <th> Actions </th>
                             </tr>
                          </thead>
                          <tbody>
                            @php
                              $i = 0;
                            @endphp
                            @foreach ($categories as $category)
                            <tr class="bold">
                               <td> {{++$i}} </td>
                               <td>
                                  <h4 style="margin:0px;">{{$category->name}}</h4>
                               </td>
                               <td>
                                  <button class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$category->id}}">Edit</button>
                                  <button id="featureStatusBtn29" class="btn btn-danger" type="button" name="button" data-toggle="modal" data-target="#deleteModal{{$category->id}}">Delete</button>
                               </td>
                            </tr>
                            @includeif('admin.categoryManagement.edit')
                            @includeif('admin.categoryManagement.delete')
                            @endforeach
                          </tbody>
                       </table>
                    </div>
                    <!-- print pagination -->
                    <div class="row">
                       <div class="text-center">
                          {{$categories->links()}}
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

  {{-- Add Modal --}}
  @includeif('admin.categoryManagement.add')
@endsection
