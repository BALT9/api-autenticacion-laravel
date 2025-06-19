<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    //
    public function funListar(Request $request)
    {
        // sql 
        // $users = DB::select("select * from users");

        // $users = DB::table("users")->get();

        // $users = User::all();

        $limit = isset($request->limit)?$request->limit:10;

        $users = User::orderby('id','desc')
                        ->where("email","like","%$request->buscar%")
                        ->with("roles")
                        ->paginate($limit);

        return response()->json($users, 200);
    }

    public function funGuardar(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:6"
        ]);

        // Eloquent orm 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['mensaje' => 'Usuario guardado', 'usuario' => $user], 201);
    }

    public function funMostrar($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user); // 200 OK por defecto
    }

    public function funModificar($id, Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email,$id"
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request -> password)){
            $user->password = $request->password;
        }
        $user->update();

        // asignar roles 

        return response()->json(['mensaje' => 'Usuario actualizado', 'usuario' => $user], 200);
    }

    public function funEliminar($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['mensaje' => 'Usuario eliminado'], 200);
    }

    public function funActualizarRoles($id,Request $request){
        $usuario = User::find($id);
        // estoy usando el metodo roles() del modelo user
        $usuario->roles()->sync($request["roles_id"]);

        return response()->json(['mensaje' => 'Roles actualizados']);
    }
}
