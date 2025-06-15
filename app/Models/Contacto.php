<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    //contacto pertenece a entidad comercial
    public function entidad_comercial(){
        return $this -> belongsTo(EntidadComercial::class);
    }
}
