<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $password;
    public $subject = "KTown: Password Reset Request";
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.password_reset', [
            'user' => $this->user,
            'password' => $this->password
        ]);
    }
}
