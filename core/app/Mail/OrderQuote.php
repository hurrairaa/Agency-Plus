<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderQuote extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $subject;
    public $fields;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from, $subject, $fields)
    {
        $this->sender = $from;
        $this->subject = $subject;
        $this->fields = $fields;
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
        ->view('mail.quote');
    }
}
