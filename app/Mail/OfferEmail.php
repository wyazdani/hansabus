<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $price;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inquiry_id,$price)
    {
        $this->inquiry  =   Inquiry::find($inquiry_id);
        $this->price    =   $price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->inquiry->email)
            ->subject(' Offer')
            ->view('mail.offer');
    }
}
