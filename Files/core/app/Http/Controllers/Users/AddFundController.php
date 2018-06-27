<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as User;
use App\Deposit as Deposit;
use App\Service as Service;
use App\Category as Category;
use App\GeneralSettings as GS;
use App\Gateway as Gateway;
use Stripe\Stripe;
use Stripe\Token;
use Stripe\Charge;
use CoinGate\CoinGate;
use App\Lib\coinPayments;
use App\Lib\BlockIo;
use App\Social as Social;
use App\Support as Support;
use App\Slider as Slider;
use App\Ad;
use Auth;
use Session;

class AddFundController extends Controller
{

    public function index() {
        $data['user'] = User::find(Auth::user()->id);
        $data['featuredGigs'] = Service::where('feature', 1)->get();
        $data['categories'] = Category::where('deleted', 0)->get();
        $data['gateways'] = Gateway::all();
        $data['supports'] = Support::all();
        $data['gs'] = GS::first();
        $data['socials'] = Social::all();
        $data['longAd'] = Ad::where('size', 3)->where('type', 1)->inRandomOrder()->get();
        $data['smallAd'] = Ad::where('size', 1)->where('type', 1)->inRandomOrder()->get();
        // checking if the email is verified
        if(Auth::check() && Auth::user()->email_verified == 0) {
          // sending verification code in email...
          if (Auth::user()->email_sent == 0) {
            $to = Auth::user()->email;
            $name = Auth::user()->firstname . ' ' . Auth::user()->lastname;
            $subject = "Email verification code";
            $message = "Your verification code is: " . Auth::user()->email_ver_code;
            send_email( $to, $name, $subject, $message);

            // making the 'email_sent' 1 after sending mail...
            $user = User::find(Auth::user()->id);
            $user->email_sent = 1;
            $user->save();
          }

          return view('users.verification.emailVerification', $data);
        }

        if(Auth::check() && Auth::user()->sms_verified == 0) {
          // sending verification code in email...
          if (Auth::user()->sms_sent == 0) {
            $to = Auth::user()->phone;
            $message = "Your verification code is: " . Auth::user()->sms_ver_code;
            send_sms( $to, $message);

            // making the 'email_sent' 1 after sending mail...
            $user = User::find(Auth::user()->id);
            $user->sms_sent = 1;
            $user->save();
          }

          return view('users.verification.smsVerification', $data);
        }

        // $user = User::find(Auth::user()->id);
        return view('users.AddFund.addFund', $data);
    }

    public function depositPreview(Request $request) {

        $validatedData = $request->validate([
            'amount' => [
                'required',
                function($attribute, $value, $fail) use ($request) {
                    if ($value > $request->maxamo) {
                        return $fail('You can deposit maximum ' . $request->maxamo);
                    }
                },
                function($attribute, $value, $fail) use ($request) {
                    if ($value < $request->minamo) {
                        return $fail('You can deposit minimum ' . $request->minamo);
                    }
                }
            ]

        ]);

        $user = User::find(Auth::user()->id);
        $gateway = Gateway::find($request->gateway);
        $gateways = Gateway::all();
        $featuredGigs = Service::where('feature', 1)->get();
        $categories = Category::where('deleted', 0)->get();
        $amount = $request->amount + ($gateway->chargefx + (($gateway->chargepc*$request->amount)/100));
        $wcAmount = $request->amount;
        $gs = GS::first();
        $sliders = Slider::all();
        $supports = Support::all();
        $socials = Social::all();
        $longAd = Ad::where('size', 3)->where('type', 1)->inRandomOrder()->get();
        $smallAd = Ad::where('size', 1)->where('type', 1)->inRandomOrder()->get();

        // return $request->all();
        if ($gateway->id == 3 || $gateway->id == 6 || $gateway->id == 7 || $gateway->id == 8)
        {
            $all = file_get_contents("https://blockchain.info/ticker");
            $res = json_decode($all);
            $btcrate = $res->USD->last;

            $btcamount = $amount/$btcrate;
            $btc = round($btcamount, 8);

            $deposit = new Deposit;
            $deposit->user_id = Auth::id();
            $deposit->gateway_id = $gateway->id;
            $deposit->amount = $amount;
            $deposit->bcam = $btc;
            $deposit->status = 0;
            $deposit->trx = str_random(16);
            // without charge amount to show users and add to users balance...
            $deposit->wc_amount = $request->amount;

            $deposit->save();

            Session::put('track', $deposit['trx']);

            return view('users.AddFund.preview', compact('user', 'sliders', 'supports', 'socials', 'gs', 'btc','gateway','amount', 'featuredGigs', 'categories', 'gateways', 'wcAmount', 'smallAd', 'longAd'));
        } else {
            $deposit = new Deposit;
            $deposit->amount = $amount;
            $deposit->gateway_id = $request->gateway;
            $deposit->user_id = Auth::user()->id;
            $deposit->status = 0;
            $deposit->trx = str_random(16);
            // without charge amount to show users and add to users balance...
            $deposit->wc_amount = $request->amount;
            $deposit->save();

            Session::put('track', $deposit['trx']);

            // return $gateway;
            return view('users.AddFund.preview', ['user' => $user, 'smallAd' => $smallAd, 'longAd' => $longAd, 'gs' => $gs, 'wcAmount' => $wcAmount, 'gateway' => $gateway, 'amount' => $amount, 'featuredGigs' => $featuredGigs, 'categories' => $categories, 'gateways' => $gateways, 'supports' => $supports, 'socials' => $socials, 'sliders' => $sliders]);
        }

    }

    public function success () {
      return view('users.AddFund.success');
    }

    public function depositConfirm() {
        $gnl = GS::first();
        $gs = GS::first();
        $sliders = Slider::all();
        $supports = Support::all();
        $socials = Social::all();
        $featuredGigs = Service::where('feature', 1)->get();
        $categories = Category::where('deleted', 0)->get();
        $gateways = Gateway::all();
        $track = Session::get('track');
        $longAd = Ad::where('size', 3)->where('type', 1)->inRandomOrder()->get();
        $smallAd = Ad::where('size', 1)->where('type', 1)->inRandomOrder()->get();
    	$data = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();
        $user = User::find(Auth::user()->id);

    		if($data->status!=0)
    		{
    			return redirect()->route('addFund');
    			exit();
    		}
        $gatewayData = Gateway::where('id', $data->gateway_id)->first();

    		if ($data->gateway_id==1)
    		{
    			$amount = $data->amount;

    			$paypal['amount'] = $amount;
    			$paypal['sendto'] = $gatewayData->val1;
    			$paypal['track'] = $track;

    			return view('users.AddFund.paypal', compact('user', 'paypal', 'gnl', 'gs', 'sliders', 'supports', 'socials', 'featuredGigs', 'categories', 'gateways', 'longAd', 'smallAd'));

    		}
    		elseif ($data->gateway_id==2)
    		{
    			$amount = $data->amount;

    			$perfect['amount'] = $amount;
    			$perfect['value1'] = $gatewayData->val1;
    			$perfect['value2'] = $gatewayData->val2;
    			$perfect['track'] = $track;
    			return view('users.AddFund.perfect', compact('user', 'perfect', 'gnl', 'gs', 'sliders', 'supports', 'socials', 'featuredGigs', 'categories', 'gateways', 'longAd', 'smallAd'));
    		}
    		elseif ($data->gateway_id==3)
    		{

    			$all = file_get_contents("https://blockchain.info/ticker");
    			$res = json_decode($all);
    			$btcrate = $res->USD->last;

    			$amount = $data->amount;
    			$btcamount = $amount/$btcrate;
    			$btc = round($btcamount, 8);

    			$DepositData = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();

    			if($DepositData->bcam == 0){
    				$blockchain_root = "https://blockchain.info/";
    				$blockchain_receive_root = "https://api.blockchain.info/";
    				$mysite_root = url('/');
    				$secret = "ABIR";
    				$my_xpub = $gatewayData->val2;
    				$my_api_key = $gatewayData->val1;

    				$invoice_id = $track;
    				$callback_url = $mysite_root . "/ipnbtc?invoice_id=" . $invoice_id . "&secret=" . $secret;


    				$resp = @file_get_contents($blockchain_receive_root . "v2/receive?key=" . $my_api_key . "&callback=" . urlencode($callback_url) . "&xpub=" . $my_xpub);

    				if (!$resp) {

    //BITCOIN API HAVING ISSUE. PLEASE TRY LATER
    					return redirect()->route('addFund')->with('alert', 'BLOCKCHAIN API HAVING ISSUE. PLEASE TRY LATER');
    					exit;
    				}

    				$response = json_decode($resp);
    				$sendto = $response->address;

    // $sendto = "1HoPiJqnHoqwM8NthJu86hhADR5oWN8qG7";

    				$data->bcid = $sendto;
    				$data->bcam = $btc;
    				$data->save();

    			}
    			$DepositData = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();
    /////UPDATE THE SEND TO ID

    			$bitcoin['amount'] = $DepositData->bcam;
    			$bitcoin['sendto'] = $DepositData->bcid;

    			$var = "bitcoin:$DepositData->bcid?amount=$DepositData->bcam";
    			$bitcoin['code'] =  "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$var&choe=UTF-8\" title='' style='width:300px;' />";

    			return view('users.AddFund.bitcoin', compact('user', 'bitcoin', 'gs', 'sliders', 'supports', 'socials', 'featuredGigs', 'categories', 'gateways', 'longAd', 'smallAd'));
    		}
    		elseif($data->gateway_id == 4)
    		{
    			return view('users.AddFund.stripe', compact('user', 'gs', 'sliders', 'supports', 'socials', 'featuredGigs', 'categories', 'gateways', 'longAd', 'smallAd'));
    		}
    		elseif($data->gateway_id == 6)
    		{
    			return redirect()->route('coinGate');
    		}
    //Manual Payments
    		elseif($data->gateway_id == 7)
    		{
    			$all = file_get_contents("https://blockchain.info/ticker");
    			$res = json_decode($all);
    			$btcRate = $res->USD->last;
    			$amount = $data->amount;
    			$bcoin = round($amount/$btcRate,8);
    			$method = Gateway::find(7);

    // You need to set a callback URL if you want the IPN to work
    			$callbackUrl = route('ipn.coinPay');

    // Create an instance of the class
    			$CP = new coinPayments();

    // Set the merchant ID and secret key (can be found in account settings on CoinPayments.net)
    			$CP->setMerchantId($method->val1);
    			$CP->setSecretKey($method->val2);

    // Create a payment button with item name, currency, cost, custom variable, and the callback URL

    			$ntrc = $data->trx;

    			$form = $CP->createPayment('Purchase Coin', 'BTC',  $bcoin, $ntrc, $callbackUrl);

    			return view('users.AddFund.coinpay', compact('user', 'bcoin','amount','form', 'gs', 'sliders', 'supports', 'socials', 'featuredGigs', 'categories', 'gateways', 'longAd', 'smallAd'));
    		}
    		elseif($data->gateway_id ==8)
    		{
    			$all = file_get_contents("https://blockchain.info/ticker");
    			$res = json_decode($all);
    			$btcRate = $res->USD->last;
    			$amount = $data->amount;
    			$bcoin = round($amount/$btcRate,8);
    			$method = Gateway::find(8);

    			$DepositData = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();

    			if($DepositData->bcid == ""){

    				$apiKey = $method->val1;
    $version = 2; // API version
    $pin =  $method->val2;
    $block_io = new BlockIo($apiKey, $pin, $version);
    $ad = $block_io->get_new_address();


    if ($ad->status == 'success')
    {
    	$data = $ad->data;
    	$sendadd = $data->address;

    	$DepositData['bcid'] = $sendadd;
    	$DepositData['bcam'] = $bcoin;
    	$DepositData->save();
    }
    else
    {
    	return back()->with('alert', 'Failed to Process');
    }
    }

    $DepositData = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();

    $sendadd = $DepositData->bcid;
    $bcoin = $DepositData->bcam;


    $varb = "bitcoin:".$DepositData->bcid ."?amount=".$DepositData->bcam;
    $qrurl =  "<img src=\"https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$varb&choe=UTF-8\" title='' style='width:300px;' />";

    return view('users.AddFund.blockio', compact('user', 'bcoin','amount','sendadd','qrurl', 'gs', 'sliders', 'supports', 'socials', 'featuredGigs', 'categories', 'gateways', 'longAd', 'smallAd'));
    }
    }

    public function ipnpaypal(){

      $raw_post_data = file_get_contents('php://input');
      $raw_post_array = explode('&', $raw_post_data);
      $myPost = array();
      foreach ($raw_post_array as $keyval){
        $keyval = explode ('=', $keyval);
        if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
      }


      $req = 'cmd=_notify-validate';
      if(function_exists('get_magic_quotes_gpc')){
        $get_magic_quotes_exists = true;
      }
      foreach ($myPost as $key => $value){
        if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
          $value = urlencode(stripslashes($value));
        } else {
          $value = urlencode($value);
        }
        $req .= "&$key=$value";
      }

      $paypalURL = "https://ipnpb.paypal.com/cgi-bin/webscr?";
      $callUrl = $paypalURL.$req;
      $verify = file_get_contents($callUrl);
      if($verify=="VERIFIED") {
        ///////////////////////////////////////PAYPAL VERIFIED THE PAYMENT

        $receiver_email  = $_POST['receiver_email'];
        $mc_currency  = $_POST['mc_currency'];
        $mc_gross  = $_POST['mc_gross'];
        $track = $_POST['custom'];

        ////////////////GRAB DATA FROM DATABASE!!
        $data = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();
        $gatewayData = Gateway::find(1);
        $amount = $data->amount;

        if($receiver_email==$gatewayData->val1 && $mc_currency=="USD" && $mc_gross ==$amount && $data->status=='0'){
          ///// DATABASE DATA AND IPN DATA VEIFIED
          ////////// ADD MONEY AND DO WHATEVER NEEDED
          //######################################################
          //###########DO NOT FORGET TO UPDATE STATUS TO 1########
          //######################################################


          $user = User::find($data->user_id);
          $user['balance'] = $user->balance + $data->wc_amount;
          $user->save();

          $data['status'] = 1;
          $data->save();



        }
      }

    }

    public function ipnperfect()
    {

    	$gatewayData = Gateway::find(2);

    	$passphrase=strtoupper(md5($gatewayData->val2));


    	define('ALTERNATE_PHRASE_HASH',  $passphrase);
    	define('PATH_TO_LOG',  '/somewhere/out/of/document_root/');
    	$string=
    	$_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
    	$_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
    	$_POST['PAYMENT_BATCH_NUM'].':'.
    	$_POST['PAYER_ACCOUNT'].':'.ALTERNATE_PHRASE_HASH.':'.
    	$_POST['TIMESTAMPGMT'];

    	$hash=strtoupper(md5($string));
    	$hash2 = $_POST['V2_HASH'];

    	if($hash==$hash2){

    		$amo = $_POST['PAYMENT_AMOUNT'];
    		$unit = $_POST['PAYMENT_UNITS'];
    		$track = $_POST['PAYMENT_ID'];

    		$depositData = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();
    		$amount = $depositData->amount;

    		if($_POST['PAYEE_ACCOUNT']==$gatewayData->val1 && $unit=="USD" && $amo ==$amount && $depositData->status=='0'){

    			$user = User::find($depositData['user_id']);
    			$user['balance'] =  $user['balance'] + $depositData['wc_amount'];
    			$user->save();

    			$sellData['status'] = 1;
    			$sellData->save();

    			return redirect()->route('home')->with('success', 'Deposit Successfull!');

    		}
    	}

    }

    public function ipnstripe(Request $request)
    {
    	$track =   Session::get('track');
    	$data = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();

    	$this->validate($request,
    		[
    			'cardNumber' => 'required',
    			'cardExpiry' => 'required',
    			'cardCVC' => 'required',
    		]);

    	$cc = $request->cardNumber;
    	$exp = $request->cardExpiry;
    	$cvc = $request->cardCVC;

    	$exp = $pieces = explode("/", $_POST['cardExpiry']);
    	$emo = trim($exp[0]);
    	$eyr = trim($exp[1]);
    	$cnts = $data->amount*100;

    	$gatewayData = Gateway::find(4);

    	Stripe::setApiKey($gatewayData->val1);

    	try{
    		$token = Token::create(array(
    			"card" => array(
    				"number" => "$cc",
    				"exp_month" => $emo,
    				"exp_year" => $eyr,
    				"cvc" => "$cvc"
    			)
    		));

    		try{
    			$charge = Charge::create(array(
    				'card' => $token['id'],
    				'currency' => 'USD',
    				'amount' => $cnts,
    				'description' => 'item',
    			));


    			if ($charge['status'] == 'succeeded') {

    				$user = User::find($data['user_id']);
    				$user['balance'] =  $user['balance'] + $data['wc_amount'];
    				$user->save();

    				$data['status'] = 1;
    				$data->save();

    				return redirect()->route('addFund.success');

    			}

    		}
    		catch (Exception $e){
    			return redirect()->route('addFund')->with('alert', $e->getMessage());
    		}

    	}catch (Exception $e){
    		return redirect()->route('addFund')->with('alert', $e->getMessage());
    	}

    }

    
    public function coingatePayment()
    {
    	$track = Session::get('track');

    	if (is_null($track))
    	{
    		return redirect()->back();
    	}

    	$depositData = Deposit::where('trx',$track)->first();

    	$amount = $depositData->amount;

    	$gateway =Gateway::find(6);
      //return $sellData;
      	\CoinGate\CoinGate::config(array(
      'environment' => 'sandbox', // sandbox OR live
      'app_id'      =>  $gateway->val1,
      'api_key'     =>  $gateway->val2,
      'api_secret'  =>  $gateway->val3
      ));

    	$post_params = array(
    		'order_id'          => $depositData->trx,
    		'price'             => $amount,
    		'currency'          => 'USD',
    		'receive_currency'  => 'USD',
    		'callback_url'      => route('ipn.coinGate'),
    		'cancel_url'        => route('addFund'),
    		'success_url'       => route('addFund'),
    		'title'             => 'Deposit dollars #'.$depositData->trx,
    		'description'       => 'Deposit dollars'
    	);

    	$order = \CoinGate\Merchant\Order::create($post_params);

    	if ($order)
    	{
    		return redirect($order->payment_url);
    	} else {
    		echo "Something Wrong with your API";
    	}
    }

    public function coinGateIPN(Request $request)
    {

    	$depositData = Deposit::where('trx',$request->order_id)->first();
    	$amount = $depositData->amount;

    	if($request->status=='paid'&&$request->price==$amount && $depositData->status=='0')
    	{
    		$user = User::find($depositData['user_id']);
    		$user['balance'] =  $user['balance'] + $depositData['wc_amount'];
    		$user->save();

    		$depositData['status'] = 1;
    		$depositData->save();

    		return redirect()->route('addFund')->with('success', 'Payment Complete via CoinGate');
    	}
    }

    public function ipnbtc(){

    	$gatewayData = Gateway::find(3);

    	$track = $_GET['invoice_id'];
    	$secret = $_GET['secret'];
    	$address = $_GET['address'];
    	$value = $_GET['value'];
    	$confirmations = $_GET['confirmations'];
    	$value_in_btc = $_GET['value'] / 100000000;

    	$trx_hash = $_GET['transaction_hash'];

    	$DepositData = Deposit::where('trx',$track)->orderBy('id', 'DESC')->first();


    	if ($DepositData->status==0) {

    		if ($DepositData->bcam==$value_in_btc && $DepositData->bcid==$address && $secret=="ABIR" && $confirmations>2){

    			$DepositData['status'] = 1;

    			$user = User::find($DepositData['user_id']);
    			$user['balance'] =  $user['balance'] + $DepositData['wc_amount'];
    			$user->save();

    			$DepositData->save();

    			return redirect()->route('addFund')->with('success', 'Deposit Successfull!');

    		}

    	}

    }

    public function ipncoin(Request $request)
    {

    	$track = $request->custom;
    	$status = $request->status;
    	$amount1 = floatval($request->amount1);
    	$currency1 = $request->currency1;

    	$DepositData = Deposit::where('trx', $track)->first();
    	$bcoin = $DepositData->bcam;

    	if ($currency1 == "BTC" && $amount1 >= $bcoin && $DepositData->status == '0')
    	{

    		if ($status>=100 || $status==2)
    		{
    			$user = User::find($DepositData['user_id']);
    			$user['balance'] =  $user['balance'] + $DepositData['amount'];
    			$user->save();

    			$DepositData['status'] = 1;
    			$DepositData->save();
    		}
    	}

    }

    public function blockIpn(Request $request)
    {



    	$DepositData = Deposit::where('status', 0)->where('gateway_id', 8)->where('try','<=',100)->get();


    	$method = Gateway::find(8);
    	$apiKey = $method->val1;
        $version = 2; // API version
        $pin =  $method->val2;
        $block_io = new BlockIo($apiKey, $pin, $version);


    foreach($DepositData as $data)
    {
    	$balance = $block_io->get_address_balance(array('addresses' => $data->bcid));


    	$bal = $balance->data->available_balance;

    	echo $data->bcid."-".$bal.'<br>';


    	if($bal > 0 && $bal >= $data->bcam)
    	{
	        $user = User::find($DepositData['user_id']);
			$user['balance'] =  $user['balance'] + $DepositData['amount'];
			$user->save();


    		$data['status'] = 1;
    		$data['try'] = $data->try+ 1;
    		$data->save();
    	}
    	$data['try'] = $data->try + 1;
    	$data->save();
    }
    }

}
