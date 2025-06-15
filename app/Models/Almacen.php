<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    public function sucursal(){
        // almacen pertenece a una sucursal
        return $this->belongsTo(Sucursal::class);
    }

    public function productos(){
        // un rol pertenece a muchos usuarios 
        return $this->belongsToMany(Producto::class)
                    ->withTimestamps()
                    ->withPivot(['cantidad_actual','fecha_actualizacion']);
    }

    //almacen tiene notas
    public function notas(){
        return $this->belongsToMany(Nota::class, "movimentos")
                    ->withTimestamps()
                    ->withPivot(["producto_id","cantidad","tipo_movimiento","precio_unitario_compra","precio_unitario_venta","total_linea","observaciones"]);
    }
}
