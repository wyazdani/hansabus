<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Tour;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TourConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $tour;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer_id,$tour_id)
    {
        $this->customer =   Customer::find($customer_id);
        $this->tour     =   Tour::find($tour_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->customer->email)
            ->subject(' TourConfirmation')
            ->view('mail.tour_confirmation');
    }
}
