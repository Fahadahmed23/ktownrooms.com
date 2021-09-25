<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Mail;
use App\Libraries\Sms;

use App\Models\Configuration;
use App\Models\SmsNotification;

/* A Custom Notification class for sending both email and sms at once. */
class Notification {
    protected $email_address;
    protected $email;
    protected $sms;

    public function send() {
        // send sms
        $this->sms->send();

        // send email
        Mail::to($this->email_address)->send($this->email);
    }

    public static function smsAdmin($status) {
        // load phone no from configurations table
        $admin_phone = Configuration::first(['AdminPhone']);

        // load message from sms_notifications table
        $sms_message = SmsNotification::where('type', $type)->first();

        // send sms
        Sms::send($admin_phone, $sms_message);
    }
}