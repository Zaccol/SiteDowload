<?php
use App\GeneralSettings as Gsetting;
use App\Ad;


if (! function_exists('send_email')) {

    function send_email( $to, $name, $subject, $message)
    {
        $settings = Gsetting::first();
        $template = $settings->email_template;
        $from = $settings->email_sent_from;
		// if($settings->email_notification == 1)
		// {
		$headers = "From: $settings->website_title <$from> \r\n";
		$headers .= "Reply-To: $settings->website_title <$from> \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$mm = str_replace("{{name}}",$name,$template);
		$message = str_replace("{{message}}",$message,$mm);

		mail($to, $subject, $message, $headers);

		// }

    }
}

if (! function_exists('send_sms'))
{

    function send_sms( $to, $message)
    {
        $settings = Gsetting::first();
		// if($settings->sms_notification == 1)
		// {

		$sendtext = urlencode("$message");
	    $appi = $settings->smsApi;
		$appi = str_replace("{{number}}",$to,$appi);
		$appi = str_replace("{{message}}",$sendtext,$appi);
		$result = file_get_contents($appi);
		// }

    }
}

if(!function_exists('show_ad')) {
    function show_ad($size) {
        $ad = Ad::where('size', $size)->where('type', 1)->inRandomOrder()->get();
        if(!empty($ad)) {
            return $ad;
        } else {
            $ad = Ad::where('size', $size)->where('type', 2)->inRandomOrder()->get();
            return $ad;
        }
    }
}
