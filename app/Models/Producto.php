<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function almacenes(){
        return $this->belongsToMany(Almacen::class)
                        ->withTimestamps()
                        ->withPivot(['cantidad_actual','fecha_actualizacion']);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
}
