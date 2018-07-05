@extends('users.layout.master')

@section('title', 'Deposit Preview')

@section('content')
  <div class="jumbotron">
    <h3>
      Vous allez déposer <strong>{{$wcAmount}}{{$gs->base_curr_symbol}}</strong> à votre compte
      <br><br>
      en utilisant <strong>{{$gateway->name}}</strong> passerelle de paiment.
    </h3>
    <h3><strong>{{$amount}}{{$gs->base_curr_symbol}}</strong> sera coupé de votre {{$gateway->name}} account.</h3>
    <a href="{{route('deposit.confirm')}}" class="btn btn-primary">Déposer maintenant</a>
  </div>
@endsection
