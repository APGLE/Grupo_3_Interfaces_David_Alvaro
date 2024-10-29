<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Muestra el listado de usuarios.
     */
    public function dashboard()
    {
        $users = User::whereIn('role', ['u', 'o'])->where('deleted' == 0)->get();
        dd($users);
        return view('home', compact('users'));
    }

    /**
     * Activa un usuario especificado.
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->actived = true;
        $user->save();

        return redirect()->back()->with('success', 'Usuario activado exitosamente.');
    }

    /**
     * Desactiva un usuario especificado.
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->actived = false;
        $user->save();

        return redirect()->back()->with('success', 'Usuario desactivado exitosamente.');
    }

    /**
     * Muestra el formulario de edición para un usuario específico.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    /**
     * Actualiza los datos del usuario en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        // Solo actualiza la contraseña si se ha proporcionado
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('home')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->deleted = 1;
        $user->save();


        
        return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
    }
}