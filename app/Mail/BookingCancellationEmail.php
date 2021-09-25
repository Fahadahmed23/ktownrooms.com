<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Booking;

class BookingCancellationEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $booking;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $subject)
    {
        $this->booking = $booking;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.cancel_booking', [
            'booking' => $this->booking
        ]);
    }
}
