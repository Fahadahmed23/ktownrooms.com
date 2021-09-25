<?php

// uses generic notification class for sending booking notifications
namespace App\Libraries\Notifications;

use App\Models\Booking;
use App\Mail\BookingEmail;
use App\Libraries\Notification;
use App\Libraries\Sms;

class BookingNotification extends Notification {
    private $subject = "Booking Confirmation";
    private $booking;

    public function __construct (Booking $booking) {
        $this->booking = $booking;
    }

    // Dependency Injection
    public function build () {
        $this->email = new BookingEmail($this->booking, $this->subject);
        $this->email_address = $this->booking->customer->Email;

        $message = "Dear " . $this->booking->customer->FirstName . ', Your booking with id ' . $this->booking->id . ' at KTown Rooms is confirmed.';
        $this->sms = new Sms(substr ($this->booking->customer->Phone, 1), $message);
    }
}