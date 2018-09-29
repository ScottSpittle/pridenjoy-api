<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $name;

    /**
     * ActivationRequest constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {

        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('spittlescott+admin@gmail.com', 'Pride-N-Joy')
                    ->view('contact_request')
                    ->with([
                        'title' => 'Thanks for getting in touch',
                        'bodyMessage' => '
                                <p>Hello '.$this->name.',</p>

                                <br/>
                                <p>Thank you for getting in touch</p>
                                <p>I\'ll be sure to respond as soon as I can</p>

                                <br/>
                                <p>Thanks,</p>
                                <p>Pride-N-Joy!</p>
                        '
                    ]);
    }
}
