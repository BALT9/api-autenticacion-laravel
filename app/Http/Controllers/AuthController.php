<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funLogin(Request $request)
    {
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (!Auth::attempt($credenciales)) {
            return response()->json(["mensaje" => "credenciales incorrectas"]);
        }

        // generar token 
        $token = $request->user()->createToken("Auth Token")->plainTextToken;

        $usuario = $request->user();

        $array_permisos = [];
        if(count($usuario->roles)>0){
            $array_permisos = $usuario->roles()
                                    ->with('permisos')
                                    ->get()
                                    // pluck solo obtiene el dato q quiero 
                                    ->pluck('permisos')
                                    // flatten une los 2 arrays de permisos a 1 array 
                                    ->flatten()
                                    ->map(function ($permiso){
                                        return array('action' => $permiso->action, 'subject' => $permiso->subject, 'name' => $permiso->nombre);
                                    })-> unique();
        }
        
        return response()->json(["acces_token" => $token, "user" => $request->user(), "permisos"=>$array_permisos], 201);
    
    }

    public function funRegister(Request $request)
    {
        //validar datos
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "cpassword" => "required|same:password",
        ]);

        // registrar 
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();

        return response()->json(["mensaje" => "usuario registrado"]);
    }

    public function funProfile(Request $request) {
        $perfil = $request->user();
        return response()->json($perfil,200);
    }

    public function funLogout(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(["mensaje" => "sesion cerrada",200]);
    }
}
