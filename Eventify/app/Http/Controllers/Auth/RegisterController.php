<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\VerificationEmail; 
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Método para mostrar el formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Validar los datos de entrada
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    protected function create(array $data)
{
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'email_verified_at' => null, 
    ]);

    $verificationUrl = \URL::signedRoute(
        'verification.verify',
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );
    

    // Enviar el correo de verificación
    Mail::to($user->email)->send(new VerificationEmail($user));


    return $user;
}

    // Método de registro
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());

        return redirect($this->redirectTo)->with('success', 'Registro exitoso. Por favor verifica tu correo.');
    }
}
