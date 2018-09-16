<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationRequest extends Mailable
{
    use Queueable, SerializesModels;

    private $expiry_date;

    private $discount_code;

    private $token;

    /**
     * Create a new message instance.
     *
     * @param $expiry_date
     * @param $discount_code
     * @param $token
     */
    public function __construct($expiry_date, $discount_code, $token)
    {
        $this->expiry_date = $expiry_date;
        $this->discount_code = $discount_code;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('activation_request')
                    ->with([
                        'title' => 'Password Reset Authentication',
                        'bodyMessage' => '
                                <p>Hello ScottSpittle,</p>

                                <p>You have recently signed up with Pride-N-Joy under this email address.</p>
                                <p>Use the following discount code for your introductory 10% off, it will expire on '.$this->expiry_date.', 
                                CODE: <span style="color: blue; font-weight: 700;"> '.$this->discount_code.' </span></p>
                                
                                <p>To confirm your registration details, click the below link: <br/>
                                <a href="'.env("FRONT_URL").'auth/activate?token='.$this->token.'">Activate Account</a>
                                </p>

                                <p>Thanks,</p>
                                <p>Pride-N-Joy!</p>
                        '
                    ]);
    }
}
