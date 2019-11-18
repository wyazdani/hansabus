<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InquiryEmailCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inquiry_id)
    {
        $this->inquiry      =   Inquiry::find($inquiry_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->inquiry->email)
            ->subject('HansaBus')
            ->view('mail.customer_inquiry');
    }
}
