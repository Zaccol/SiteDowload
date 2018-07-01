@extends('users.layout.master')

@section('title', 'Deposit Preview')

@section('content')
  <div class="jumbotron">
    <h3>
      You are going to deposit <strong>{{$wcAmount}}{{$gs->base_curr_symbol}}</strong> to your account
      <br><br>
      using <strong>{{$gateway->name}}</strong> payment gateway.
    </h3>
    <h3><strong>{{$amount}}{{$gs->base_curr_symbol}}</strong> will be cut from your {{$gateway->name}} account.</h3>
    <a href="{{route('deposit.confirm')}}" class="btn btn-primary">Deposit Now</a>
  </div>
@endsection
