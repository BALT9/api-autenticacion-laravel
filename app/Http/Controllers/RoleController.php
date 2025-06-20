<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // permisos para el usuario 
        Gate::authorize('listar-rol');

        $roles = Role::with(["permisos"])->get();
        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // permisos para el usuario 
        Gate::authorize('create-rol');

        $request->validate([
            "nombre" => "required"
        ]);
        $role = new Role();
        $role->nombre = $request->nombre;
        $role->descripcion = $request->descripcion;
        $role->save();
        
        return response()->json(["message" => "Rol registrado correctamente.."]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // permisos para el usuario 
        Gate::authorize('show-rol');

        $role = Role::findOrFail($id);

        return response()->json($role);
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // permisos para el usuario 
        Gate::authorize('update-rol');

        $request->validate([
            "nombre" => "required"
        ]);

        $role = Role::findOrFail($id);
        $role->nombre = $request->nombre;
        $role->descripcion = $request->descripcion;
        $role->update();
        
        return response()->json(["message" => "Rol actualizado correctamente.."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function funActualizarPermisos($id, Request $request){
        // permisos para el usuario 
        Gate::authorize('update-rol');

        $role = Role::find($id);

        // estoy usando el metodo permisos() del modelo Role 
        $role->permisos()->sync($request["permisos_id"]);

        return response()->json(["message" => "Permisos actualizados correctamente.."]);
    }
}
