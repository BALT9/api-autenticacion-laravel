<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $casts = [
        'activo' => 'boolean',
    ];

    public function almacens(){
        return $this->belongsToMany(Almacen::class, "almacen_producto",'producto_id','almacen_id')
                        ->withTimestamps()
                        ->withPivot(['cantidad_actual','fecha_actualizacion']);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
}
