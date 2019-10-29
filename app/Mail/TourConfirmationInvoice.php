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
    public $subject;
    public $body;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer_id,$tour_id,$subject,$body)
    {
        $this->customer =   Customer::find($customer_id);
        $this->tour_id  =   $tour_id;
        $this->tour     =   Tour::find($tour_id);
        $this->subject     =   $subject;
        $this->body     =   $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject    =   $this->subject;
        $body       =   $this->body;
        $total=0;

        /*$invoice = TourInvoiceDetail::where('tour_id','=',$this->tour_id)->first();*/
        $invoice = TourInvoiceDetail::join('tour_invoice as ti','ti.id','tour_invoice_details.invoice_id')
                                    ->where('ti.is_bulk',0)
                                    ->where('tour_id','=',$this->tour_id)
                                    ->select('tour_invoice_details.id','tour_invoice_details.invoice_id')
                                    ->first();
        $invoice = TourInvoice::find($invoice->invoice_id);
        // Invoice Number
        $general = new General();
        $invoice->id = $general->invoiceNumber($invoice->id);

        $customer = $invoice->customer;
        $invoice_details = TourInvoiceDetail::where('invoice_id',$invoice->id)->get();
        $tour =[];
        foreach($invoice_details as $inv){
            $inv->tour;
            $inv->tour->driver;
            $inv->tour->customer;
            $inv->tour->vehicle;
            $total += $inv->tour->price;

            $tour[] = $inv->tour;
        }
        $vat = ($total/100)*19;
        $invoice_date   =   date('Y-m-d');
        $html   =   view('invoices.tour.pdf_design', compact('customer','invoice','tour','total','vat','invoice_date'));
        $pdf= General::EmailPdf("P",$html,"tour_invoice","Invoice");
        return $this->to($this->customer->email)
            ->subject($subject)
            ->view('mail.tour_confirmation')
            ->attachData($pdf,'tour_invoice.pdf');
    }
}
