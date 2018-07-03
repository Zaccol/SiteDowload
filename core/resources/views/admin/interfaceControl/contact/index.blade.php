@extends('admin.layout.master')

@section('body')
  <div class="page-content-wrapper">
     <div class="page-content" style="min-height:361px">
        <h3 class="page-title uppercase bold"> Contact Setting</h3>
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
                    <form class="form-horizontal" action="{{route('admin.contact.update')}}" method="post" role="form">
                       {{csrf_field()}}
                       <div class="form-body">
                          <div class="form-group">
                             <label class="col-md-12 "><strong style="text-transform: uppercase;">EMAIL</strong></label>
                             <div class="col-md-12">
                                <input class="form-control input-lg" name="email" value="{{$gs->email}}" type="text">
                             </div>
                          </div>
                          <div class="form-group">
                             <label class="col-md-12 "><strong style="text-transform: uppercase;">mobile</strong></label>
                             <div class="col-md-12">
                                <input class="form-control input-lg" name="phone" value="{{$gs->phone}}" type="text">
                             </div>
                          </div>
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
     </div>
  </div>
@endsection
