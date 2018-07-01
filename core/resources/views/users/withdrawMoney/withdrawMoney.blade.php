@extends('users.layout.master')

@section('title', 'Withdraw Money')

@section('profile-info')
  {{-- START: Profile Info... --}}
  <div class="widget-content">
    <div class="widget__content card__content extar-margin">
      <div class="panel-group" id="accordion">
           <div class="panel">
                <div class="panel-heading side-events-item">
                  <div class="">
                    <div>
                        <img style="display:block;margin:auto;" src="{{asset('assets/users/propics/' . $user->pro_pic)}}" alt="">
                    </div>
                 </div>
                </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <h2 style="color:white;margin:0px;"><a style="text-decoration:underline;" href="{{route('users.profile', $user->id)}}">{{$user->username}}</a></h2>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-plus" aria-hidden="true"></i> Join Date</strong> Apr 22, 2018
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-star" aria-hidden="true"></i> Buyer Rating</strong> 90%
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-thumbs-o-up"></i> Positive Rating</strong> 9
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-thumbs-o-down"></i> Negative Rating</strong> 1
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
            <div class="panel">
                 <div class="panel-heading side-events-item">
                   <div class="">
                     <div>
                         <p style="margin:0px;">
                           <strong><i class="fa fa-eye" aria-hidden="true"></i> Last Seen</strong> Today
                         </p>
                     </div>
                  </div>
                 </div>
            </div>
      </div>
    </div>
  </div>
  {{-- END: Profile Info... --}}
@endsection

@section('content')
  <div class="table-border table-responsive">
    <table class="table table-bordered ">
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
        @foreach($wms as $wm)
        <tr>
           <td id="method{{$wm->id}}">{{$wm->name}}</td>
           <td><b>{{$wm->min_limit}} </b> TO <b>{{$wm->max_limit}} {{$gs->base_curr_text}}</b></td>
           <td><b>{{$wm->fixed_charge}} </b> + <b>{{$wm->percentage_charge}} % {{$gs->base_curr_text}}</b></td>
           <td><b>{{$wm->process_time}}</b></td>
           <td>
              <button onclick="showWithdrawMoneyModal({{$wm->id}}, document.getElementById('method{{$wm->id}}').innerHTML)" type="button" class="btn btn-warning">Withdraw Money</button>
           </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Request Withdraw Modal --}}
  @includeif('users.withdrawMoney.requestWithdraw')
@endsection
