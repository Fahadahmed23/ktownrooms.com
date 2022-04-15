<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'third_party_booking', 'order-confirmation/*','blinq_archive','customer_bookings','external_customer_bookings',
        'getBookingsMiscellaneousAmount','deleteBookingsMiscellaneousAmount','saveBookingsMiscellaneousAmount'
    ];
}
