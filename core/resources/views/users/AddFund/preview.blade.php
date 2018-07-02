@extends('users.layout.master')

@section('title', 'Deposit Preview')

@section('content')
  <div class="jumbotron">
    <h3>
      Vous allez déposert <strong>{{$wcAmount}}{{$gs->base_curr_symbol}}</strong> sur votre compte
      <br><br>
      en utilisant <strong>{{$gateway->name}}</strong> la passerelle de paiement.
    </h3>
    <h3><strong>{{$amount}}{{$gs->base_curr_symbol}}</strong> sera débité de votre {{$gateway->name}} compte.</h3>
    <a href="{{route('deposit.confirm')}}" class="btn btn-primary" style="background-color:#FF1043; color:#FFFFFF; font-size:14px; font-weight:900; border-radius: 28px; border:none;">Déposer maintenant</a>
  </div>
@endsection
