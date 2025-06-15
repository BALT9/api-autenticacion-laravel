<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadComercial extends Model
{
    //cada entidad comercial puede tener muchos contactos
    public function contactos(){
        return $this->hasMany(Contacto::class);
    }

    public function notas(){
        return $this->hasMany(Nota::class);
    }
    
}
