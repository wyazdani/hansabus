<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InquiryEmailHansaBus extends Mailable
{
    use Queueable, SerializesModels;
    public $inquiry;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inquiry_id,$email)
    {
        $this->inquiry      =   Inquiry::find($inquiry_id);
        $this->email        =   $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)
            ->subject('New Inquiry')
            ->view('mail.hansabus_inquiry');
    }
}
