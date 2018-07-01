@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:392px">
        <h3 class="page-title  uppercase bold"> <i class="fa fa-desktop"></i> Support Setting
           <a href="http://fontawesome.io/icons/" target="_blank" class="btn btn-info pull-right">Font Awesome Icon Codes</a>
        </h3>
        <hr>
        <div class="row">
           <div class="col-md-12">
              <!-- BEGIN SAMPLE FORM PORTLET-->
              <div class="portlet light bordered">
                 <div class="portlet-body form">
                   @if ($errors->any())
                       <div class="alert alert-danger">
                           <ul>
                               @foreach ($errors->all() as $error)
                                   <li>{{ $error }}</li>
                               @endforeach
                           </ul>
                       </div>
                   @endif
                    <form class="form-horizontal" action="{{route('admin.support.store')}}" method="post" role="form">
                       {{csrf_field()}}
                       <div class="form-body">
                          <div class="row">
                             <div class="col-md-4">
                                <b class="btn green btn-outline btn-lg btn-block sbold uppercase">Font Awesome Icon Code</b>
                             </div>
                             <div class="col-md-8">
                                <b class="btn green btn-outline btn-lg btn-block sbold uppercase">Text</b>
                             </div>
                          </div>
                          <br><br>
                          <div class="row">
                             <div class="col-md-4">
                                <div class="input-group mb15">
                                   <span class="input-group-addon">fa fa-</span>
                                   <input class="form-control input-lg" name="icon" type="text">
                                </div>
                             </div>
                             <div class="col-md-8">
                                <input class="form-control input-lg" name="title" type="text">
                             </div>
                          </div>
                          <br><br>
                          <div class="row">
                             <div class="col-md-12">
                                <button type="submit" class="btn blue btn-block btn-lg">UPDATE</button>
                             </div>
                          </div>
                       </div>
                    </form>
                 </div>
              </div>
           </div>
        </div>
        <!---ROW-->
        <div class="row">
          <div class="col-md-12">
            <div class="portlet box green">
               <div class="portlet-title">
                  <div class="caption"><i class="fa fa-list"></i> SUPPORT LIST</div>
               </div>
               @if (count($supports) == 0)
                 <div class="portlet-body">
                   <h1 class="text-center">NO DATA FOUND</h1>
                 </div>
               @else
                       <div class="portlet-body">
                          <div class="table-scrollable">
                             <table class="table table-bordered table-hover">
                                <thead>
                                   <tr>
                                      <th> ICON </th>
                                      <th> Text </th>
                                      <th> DELETE </th>
                                   </tr>
                                </thead>
                                <tbody>
                                  @foreach ($supports as $support)
                                  <tr id="2">
                                     <td><i class="fa fa-{{$support->fontawesome_code}}"></i></td>
                                     <td>{{$support->title}}</td>
                                     <td>
                                      <button type="button" class="btn btn-danger btn-sm delete_button" data-toggle="modal" data-target="#DelModal{{$support->id}}" data-id="2">
                                      <i class="fa fa-times"></i> DELETE
                                      </button>
                                     </td>
                                  </tr>
                                  <!-- Modal for DELETE -->
                                  <div class="modal fade" id="DelModal{{$support->id}}" tabindex="-1" role="dialog">
                                     <div class="modal-content">
                                        <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                           <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-trash"></i> Delete !</h4>
                                        </div>
                                        <div class="modal-body">
                                           <strong>Are you sure you want to Delete ?</strong>
                                        </div>
                                        <div class="modal-footer">
                                           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                           <form style="display:inline-block;" class="" action="{{route('admin.support.delete')}}" method="post">
                                             {{csrf_field()}}
                                             <input type="hidden" name="supportID" value="{{$support->id}}">
                                             <button type="submit" class="btn btn-danger">DELETE</button>
                                           </form>
                                        </div>
                                     </div>
                                  </div>
                                  @endforeach
                                </tbody>
                             </table>
                          </div>
                       </div>
                    </div>
                  </div>
                </div>
                <!-- row -->

                <!-- Modal for DEL SUCCESS -->
                <div class="modal fade" id="DelDone" tabindex="-1" role="dialog">
                   <div class="modal-content">
                      <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                         <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-trash"></i> Delete!</h4>
                      </div>
                      <div class="modal-body">
                         <b class="msg"></b>
                      </div>
                      <div class="modal-footer">
                         <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                      </div>
                   </div>
                </div>
               @endif

     </div>
  </div>
@endsection
