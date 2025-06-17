<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $limit = $request->limit;
        return Producto::where("nombre", "LIKE", "%$search%")->paginate($limit);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                "nombre" => "required",
                "unidad_medida" => "required",
                "categoria_id" => "required",
                "fecha_registro" => "required",
                "precio_venta_actual" => "required"
            ]);

            //code...
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
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["message" => "Error al realizar la consulta"]);
        }
    }

    public function guardarProductoImagen(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "unidad_medida" => "required",
            "categoria_id" => "required",
            "fecha_registro" => "required",
            "precio_venta_actual" => "required",
            "stock_minimo" => "required",
            "activo" => "required"
        ]);

        $prod = new Producto();
        $prod->nombre = $request->nombre;
        $prod->unidad_medida =  $request->unidad_medida;
        $prod->categoria_id = $request->categoria_id;
        $prod->fecha_registro = $request->fecha_registro;
        $prod->descripcion = $request->descripcion;
        $prod->codigo_barra = $request->codigo_barra;
        $prod->marca = $request->marca;
        $prod->precio_venta_actual = $request->precio_venta_actual;
        $prod->stock_minimo = $request->stock_minimo;
        $prod->activo = $request->activo;

        if($file = $request->file("imagen")){
            $direccion_url = time()."-".$file->getClientOriginalName();
            $file->move("imagenes", $direccion_url);
            $prod->imagen_url = "imagenes/". $direccion_url;
        }

        $prod->save();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto); 
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
