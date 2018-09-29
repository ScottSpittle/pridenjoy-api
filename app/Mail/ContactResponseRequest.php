<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactResponseRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $name;
    private $phone;
    private $preference;
    private $message;
    private $email;

    /**
     * ActivationRequest constructor.
     *
     * @param $name
     * @param $email
     * @param $phone
     * @param $preference
     * @param $message
     */
    public function __construct($name, $email, $phone, $preference, $message)
    {

        $this->name = $name;
        $this->phone = $phone;
        $this->preference = $preference;
        $this->message = $message;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email, $this->name)
                    ->view('contact_request')
                    ->with([
                        'title' => 'Pride-N-Joy! Q/A',
                        'bodyMessage' => '
                                <p>Hello Peter,</p>
                                
                                <p>You have received the folowing message from the pride-n-joy.co.uk website</p>
                                
                                <br/>
                                <p>Name: ' . $this->name . '</p>
                                <p>Email: ' . $this->email . '</p>
                                <p>Phone: ' . $this->phone . '</p>
                                <p>Contact Preference: ' . $this->preference . '</p>
                                <p>Message: ' . $this->message . '</p>
                                   
                                <br/>
                                <p>Thanks,</p>
                                <p>Pride-N-Joy!</p>
                        '
                    ]);
    }
}
