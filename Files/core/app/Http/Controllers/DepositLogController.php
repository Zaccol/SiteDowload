<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeneralSettings as GS;
use App\Deposit as Deposit;

class DepositLogController extends Controller
{
    public function __construct() {
      $gs = GS::first();
      $this->sitename = $gs->website_title;
    }

    public function depositLog() {
        $data['sitename'] = $this->sitename;
        $data['page_title'] = 'Deposit Log';
        $data['deposits'] = Deposit::latest()->paginate(10);
        return view('admin.DepositMoney.depositLog', ['data' => $data]);
    }
}
