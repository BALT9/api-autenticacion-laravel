<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $limit = $request->limit;
        return Producto::where("nombre","LIKE","%$search%")->paginate($limit);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "unidad_medida" => "required",
            "categoria_id" => "required",
            "fecha_registro" => "required"
        ]);

        $prod = new Producto();
        $prod->nombre = $request->nombre;
        $prod->unidad_medida = $request->unidad_medida;
        $prod->categoria_id = $request->categoria_id;
        $prod->fecha_registro = $request->fecha_registro;
        $prod->descripcion = $request->descripcion;
        $prod->codigo_barra = $request->codigo_barra;
        $prod->marca = $request->marca;
        $prod->precio_venta_actual = $request->precio_venta_actual;
        $prod->stock_minimo = $request->stock_minimo;
        $prod->activo = $request->activo;
        
        $prod->save();

        return response()->json($prod);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
