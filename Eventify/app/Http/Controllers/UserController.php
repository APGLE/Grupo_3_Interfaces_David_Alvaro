<?php


namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
        //
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
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $user = User::findOrFail($id);
    return view('admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'role' => 'required|in:u,o,a',
    ]);

    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    $user->save();

    return redirect()->route('home')->with('success', 'Usuario actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $user = User::findOrFail($id);
    $user->deleted = 1;
    $user->save();

    return redirect()->route('home')->with('success', 'Usuario eliminado exitosamente.');
    }
    public function dashboard()
    {
        $users = User::all();
        return view('admin-dashboard', compact('users'));
    }
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->actived = true;
        $user->save();

        return redirect()->back()->with('success', 'Usuario activado exitosamente.');
    }

    /**
     * Desactivar el usuario especificado.
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->actived = false;
        $user->save();

        return redirect()->back()->with('success', 'Usuario desactivado exitosamente.');
    }
}
