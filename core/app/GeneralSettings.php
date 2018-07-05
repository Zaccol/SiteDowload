<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
        public $timestamps = false;

    protected $table = 'general_setting';

    protected $fillable = [
				'rate', 'website_title', 'base_color_code', 'base_curr_text', 'base_curr_symbol', 'registration', 'email_verification', 'sms_verification', 'decimal_after_pt', 'email_notification', 'sms_notification',
    ];

}
