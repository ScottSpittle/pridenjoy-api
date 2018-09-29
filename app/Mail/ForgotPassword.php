<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('forgot_password')
                    ->with([
                        'title' => 'Password Reset Authentication',
                        'bodyMessage' => '
                                <p>Hello ScottSpittle,</p>

                                <p>Click on this link to confirm that you asked for a password reset:
                                <a href="'.env("FRONT_URL").'auth/password_reset" target="_blank">Reset Password Link</a>
                                </p>

                                <p>Thanks,</p>
                                <p>Pride-N-Joy!</p>
                        '
                    ]);
    }
}
