<?php

namespace App\Mail;

use App\Models\Customer;
use App\User;
use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user   ;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user =   Customer::find($user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->subject(' Welcome')
            ->view('mail.test');
    }
}
