@extends('users.layout.master')

@section('title', 'My Shopping')

@section('content')
  <div class="shopping-container">
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#completed">Completed Orders <span class="badge">{{\App\Order::where('status', 2)->where('buyer_id', Auth::user()->id)->count()}}</span></a></li>
      <li><a data-toggle="tab" href="#corders">Current Orders <span class="badge">{{\App\Order::where('status', 1)->where('buyer_id', Auth::user()->id)->count()}}</span></a></li>
      <li><a data-toggle="tab" href="#porders">Pending Orders <span class="badge">{{\App\Order::where('status', 0)->where('buyer_id', Auth::user()->id)->count()}}</span></a></li>
      <li><a data-toggle="tab" href="#rejorders">Rejected Orders <span class="badge">{{\App\Order::where('status', -1)->where('buyer_id', Auth::user()->id)->count()}}</span></a></li>
    </ul>

    <div class="tab-content" style="padding-top:20px;">
      <div id="completed" class="tab-pane fade in active">
        @includeif('users.shopping.partials._completedOrders')
      </div>
      <div id="corders" class="tab-pane fade">
        @includeif('users.shopping.partials._currentOrders')
      </div>
      <div id="porders" class="tab-pane fade">
        @includeif('users.shopping.partials._pendingOrders')
      </div>
      <div id="rejorders" class="tab-pane fade">
        @includeif('users.shopping.partials._rejectedOrders')
      </div>
    </div>
  </div>

@endsection
