<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;

    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->view('emails.plantilla')
                    ->subject('Correo con PDF adjunto')
                    ->attachData($this->pdf, 'archivo.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
