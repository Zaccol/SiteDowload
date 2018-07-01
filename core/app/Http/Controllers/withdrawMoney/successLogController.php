<?php

namespace App\Http\Controllers\withdrawMoney;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\GeneralSettings as GS;
use App\Withdraw as Withdraw;

class successLogController extends Controller
{
    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function successLog() {
  		$data['sitename'] = $this->sitename;
  		$data['page_title'] = 'Email Setting';
      $withdraws = Withdraw::where('status', 'processed')->latest()->paginate(15);
    	return view('admin.WithdrawMoney.successLog.successLog', ['data' => $data, 'withdraws' => $withdraws]);
    }
}
