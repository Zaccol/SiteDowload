<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\User as User;

class TestController extends Controller
{
    public function test() {
	  $gs = GS::select('ref_com')->first();
      $refCom = $gs->ref_com;

      // order price without reference commision money has been added to seller balance...
      $user = User::find(1);
      $user->balance = $user->balance + ($orderInfos[0]->money-$comCharge);
      return $refCom;
    }
}
