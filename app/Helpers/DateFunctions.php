<?php

use \Carbon\Carbon;

function viewDateTime($value) {
    return (new Carbon($value, config('app.timezone')))->setTimezone(env('TIMEZONE'))->format('d-m-Y H:i a');
}