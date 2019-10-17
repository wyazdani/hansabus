<?php

namespace App\Mail;

use App\Helpers\General;
use App\Models\Customer;
use App\Models\TourInvoiceDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice;
    public $subject;
    public $body;
    public $customer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice,$subject,$body)
    {
        $this->body =   $body;
        $this->customer =   Customer::find($invoice->customer_id);
        $this->invoice  =   $invoice;
        $this->subject = $subject;
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
        $invoice    =   $this->invoice;
        $customer   =   Customer::find($invoice->customer_id);
        $invoice_details = TourInvoiceDetail::where('invoice_id',$invoice->id)->get();
        $tour =[];
        $total=0;
        $vat = ($total/100)*19;

        $invoice_date   =   date('Y-m-d');
        foreach($invoice_details as $inv){
            $inv->tour;
            $inv->tour->driver;
            $inv->tour->customer;
            $inv->tour->vehicle;
            $total += $inv->tour->price;

            $tour[] = $inv->tour;
        }
        $html   =   view('invoices.tour.pdf_design', compact('customer','invoice','tour','total','vat','invoice_date'));
        $pdf    =    General::EmailPdf("P",$html,"Invoice","Invoice");
        return $this->to($this->customer->email)
            ->subject($subject)
            ->view('mail.tour-invoice')
            ->attachData($pdf,'invoice.pdf');
    }
}
