<?php

namespace App\Mail\Proveedor;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailIsuues extends Mailable
{
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->message->get('text'));

        switch ($this->message->get('type')) {
            case 1:
                return $this->view('emails.Proveedor.ClavesolError');
                break;
            case 2:
                return $this->view('emails.Proveedor.CuentaError');
                break;
            case 3:
                //return $this->view('emails.Proveedor.subjectlError');
                return $this->view('emails.Proveedor.CuentaError');
                break;
        }
    }
}
