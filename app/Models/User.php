<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function persona(){
        // un usuario tiene una persona 
        return $this -> hasOne(Persona::class);
    }

    public function roles(){ 
        return $this -> belongsToMany(Role::class)->withTimestamps();
    }

    // asignar roles  
    public function asignarRole($role){
        if(is_string($role)){
            $role = Role::where("nombre",$role)->firstOrFail();
        }
        $this->roles()->sync($role, false);
    }

    // obtener permisos por user
    public function permisos(){
        return $this->roles->map->permisos->flatten()->pluck("nombre")->unique(); 
    }

    public function sucursales(){
        // un rol pertenece a muchos usuarios 
        return $this->belongsToMany(Sucursal::class)->withTimestamps();
    }

    public function notas(){
        return $this->hasMany(Nota::class);
    }
}
