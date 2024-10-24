<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable {
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function build() {
        return $this->markdown('emails.verification')
                    ->subject('Verifica tu dirección de correo electrónico') // Añadido el sujeto
                    ->from($this->user->email, $this->user->name); // Remitente dinámico
    }
}
