namespace App\Http\Controllers;

<<<<<<< Updated upstream

use Illuminate\Http\Request;
use App\Models\User;
=======
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
>>>>>>> Stashed changes

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Enviar correo de verificación
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Usuario creado, verifica tu correo para continuar.']);
    }
<<<<<<< Updated upstream
    public function dashboard()
    {
    $users = User::where('deleted', 0)->get(); // Excluye los usuarios "soft deleted"
    return view('admin.dashboard', compact('users'));
    }
    public function activate($id)
    {
        $user = User::findOrFail($id);

        if ($user->email_confirmed && !$user->actived) {
            $user->actived = 1;
            $user->save();

            return redirect()->route('admin.dashboard')->with('status', 'Usuario activado correctamente.');
        }

        return redirect()->route('admin.dashboard')->with('error', 'No se puede activar este usuario.');
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);

        if ($user->actived) {
            $user->actived = 0;
            $user->save();

            return redirect()->route('admin.dashboard')->with('status', 'Usuario desactivado correctamente.');
        }

        return redirect()->route('admin.dashboard')->with('error', 'No se puede desactivar este usuario.');
    }

}
=======
}
>>>>>>> Stashed changes
