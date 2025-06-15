<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // tabla de categoria (opcional) 
    // protected $table = "categorias";
    // protected $primaryKey = 'cod_cate';
    // public $incrementing = false;
    // public $keyTipe = 'string';

    // public $timestamps = false;

    public function productos(){
        return $this->hasMany(Producto::class);
    }
}
