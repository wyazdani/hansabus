<?php

namespace App\Mail;

use App\Helpers\General;
use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OfferEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $inquiry_id;
    public $price;
    public $offer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inquiry_id,$price,$offer_id)
    {
        $this->inquiry      =   Inquiry::find($inquiry_id);
        $this->price        =   $price;
        $this->offer        =   $offer_id;
        $this->inquiry_id   =   $inquiry_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $inquiry    =   Inquiry::find($this->inquiry_id);
        $html   =   view('offers.pdf_offers', compact('inquiry'));
        $pdf    =    General::EmailPdf("P",$html,"offer","offer");
        return $this->to($this->inquiry->email)
            ->subject(' Offer')
            ->view('mail.offer')
            ->attachData($pdf,'offer.pdf');
    }
}
