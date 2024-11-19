<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\EnviarPdfMail;
use Dompdf\Dompdf;

class MailController extends Controller
{
    public function enviarPdf(Request $request)
    {
        $data = ['titulo' => 'Ejemplo de PDF', 'contenido' => 'Este es el contenido del PDF'];
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
