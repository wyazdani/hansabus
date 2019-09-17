<?php

namespace App\Mail;

use App\Helpers\General;
use App\Models\Customer;
use App\Models\Tour;
use App\Models\TourInvoice;
use App\Models\TourInvoiceDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF;

class TourConfirmationInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $tour_id;
    public $tour;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer_id,$tour_id)
    {
        $this->customer =   Customer::find($customer_id);
        $this->tour_id  =   $tour_id;
        $this->tour     =   Tour::find($tour_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $total=0;
        $invoice = TourInvoice::find($this->tour_id);

        // Invoice Number
        $general = new General();
        $invoice->id = $general->invoiceNumber($invoice->id);

        $customer = $invoice->customer;
        $invoice_details = TourInvoiceDetail::where('invoice_id',$invoice->id)->get();
        $tour ='';
        foreach($invoice_details as $inv){
            $inv->tour;
            $inv->tour->driver;
            $inv->tour->customer;
            $inv->tour->vehicle;
            $total += $inv->tour->price;

            $tour = $inv->tour;
        }
        $vat = ($total/100)*19;
        $invoice_date   =   date('Y-m-d');
        $pdf = PDF::loadView('invoices.tour.pdf_design', compact('customer','invoice','tour','total','vat','invoice_date'));
        return $this->to($this->customer->email)
            ->subject(' TourConfirmation')
            ->view('mail.tour_confirmation')
            ->attachData($pdf->output(), 'tours_invoice.pdf');
    }
}
