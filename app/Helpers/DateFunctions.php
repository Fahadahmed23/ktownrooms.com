<?php

use \Carbon\Carbon;

function viewDateTime($value) {
    // return (new Carbon($value, config('app.timezone')))->setTimezone(env('APP_TIMEZONE', 'Asia/Karachi'))->format('d-m-Y H:i a');
    return (new Carbon($value, config('app.timezone')))->setTimezone(env('APP_TIMEZONE', 'Asia/Karachi'))->format('Y-m-d H:i:s');
}