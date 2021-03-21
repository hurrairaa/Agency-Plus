<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $subject;
    public $text;
    public $subsc;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from, $subject, $message, $subsc=false)
    {
        $this->sender = $from;
        $this->subject = $subject;
        $this->text = $message;
        $this->subsc = $subsc;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->sender)
        ->subject($this->subject)
        ->view('mail.contact');
    }
}
