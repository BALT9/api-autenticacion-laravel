<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
