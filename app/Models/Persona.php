<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Persona extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'persona';
    protected $fillable = [
        'dni',
        'apellidopaterno',
        'apellidomaterno',
        'nombres',
        'direccion',
        'telefono',
        'email',
    ];
    //funciones para el mantenimiento
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
   
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rolpersona');
    }

    public function usuario()
    {
        return $this->hasMany(Usuario::class);
    }
  

    public static function getUsuarios(){
        $id_rolUsuario = '1';
         $personas = Persona::whereHas('roles', function ($query) use ($id_rolUsuario) {
             $query->where('rol.id', '=', $id_rolUsuario);
         })->get();
         return $personas;
    }

    public function getFullNameAttribute(){
        return $this->apellidopaterno . ' ' . $this->apellidomaterno . ' ' . $this->nombres;
    }

    /**
     * Función para listar Personas
     *
     * @param  model $query
     * @param  string $nomber
     * @param  string $dni
     * @return sql 
     */
    public function scopelistar($query, $nombre, $dni = null)
    {
        return $query->where(function ($subquery) use ($nombre) {
            if (!is_null($nombre)) {
                    $subquery->where(DB::raw('concat(persona.apellidopaterno,\' \',persona.apellidomaterno,\' \',persona.nombres)'), 'LIKE', '%' . $nombre . '%');
                }
            })
            ->where(function ($subquery) use ($dni) {
                if (!is_null($dni)) {
                    $subquery->where('dni', '=', $dni);
                }
            })
            ->orderBy('apellidopaterno', 'ASC');        
    }
}
