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
}
