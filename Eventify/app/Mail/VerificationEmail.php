<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Esto debería ser un objeto User

    public function __construct(User $user)
    {
        $this->user = $user; // Asegúrate de que esto sea un objeto User
    }

    public function build()
    {
        return $this->view('emails.verification') // Usamos la vista de verificación
                    ->with([
                        'name' => $this->user->name, // Nombre del usuario
                        'verificationUrl' => $this->verificationUrl($this->user), // URL de verificación
                    ]);
    }

    // Generar la URL de verificación sin límite de tiempo
    protected function verificationUrl(User $user)
    {
        return URL::signedRoute(
            'verification.verify',
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );
    }
}
