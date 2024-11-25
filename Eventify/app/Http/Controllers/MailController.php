<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\EnviarPdfMail;
use Dompdf\Dompdf;
use App\Models\Event;
use App\Models\EventAttendee;

class MailController extends Controller
{
    public function enviarPdf(Request $request)
    {
        $user = Auth::user();      
        $events = Event::whereIn('id', function($query) use ($user) {
            $query->select('event_id')
                ->from('event_attendees')
                ->where('user_id', $user->id)
                ->where('deleted', 0);
        })->get();

        if ($events->isEmpty()) {
            return back()->with('error', 'No estás inscrito en ningún evento.');
        }

    foreach ($events as $event) {
        if ($event->image_url) {
            $path = public_path('images/' . $event->image_url);
            if (file_exists($path)) {
                $imageData = file_get_contents($path);
                $base64Image = base64_encode($imageData);
                $event->base64_image = 'data:image/jpeg;base64,' . $base64Image;
            }
        }
    }

        $data = [
            'titulo' => 'Informe de Eventos Registrados',
            'contenido' => 'A continuación se listan los eventos en los que estás registrado:',
            'events' => $events
        ];
        $dompdf = new Dompdf();
        $html = view('pdf.estructurapdf', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $userEmail = Auth::user()->email;
        $output = $dompdf->output();
        Mail::to($userEmail)->send(new EnviarPdfMail($output));
        
        return back()->with('success', 'Correo enviado con éxito');
    }
}
