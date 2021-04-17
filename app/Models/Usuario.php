<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Usuario extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $remember_token = 'false';
    protected $table = 'usuario';
    protected $fillable = [
        'login',
        'password',
        'persona_id',
        'tipousuario_id'
    ];
     //funciones para el manteniemto

     public function persona()
     {
         return $this->belongsTo(Persona::class, 'persona_id');
     }
     public function tipousuario()
     {
         return $this->belongsTo(TipoUsuario::class, 'tipousuario_id');
     }
     public function setSession($tipousuario)
     {
         if (count($tipousuario) == 1) {
             if($tipousuario[0]['id']==1){
                 $nombres = 'ADMIN PRINCIPAL';
             }else{
                $nombres= $this->persona()->get()->toArray()[0]['nombres'] . ' '  . $this->persona()->get()->toArray()[0]['apellidopaterno'] . ' ' . $this->persona()->get()->toArray()[0]['apellidomaterno'];
                $area = $this->persona()->with('area')->get()->toArray()[0];
            }
             Session::put([
                 'tipousuario_id' => $tipousuario[0]['id'],
                 'tipousuario_nombre' => $tipousuario[0]['descripcion'],
                 'usuario' => $this->login,
                 'accesos' => $this->tipousuario()->with('opcionmenu')->get()->toArray()[0]['opcionmenu'] ?? null,
                 'usuario_id' => $this->id,
                 'persona' => $this->persona()->with('cargo', 'area')->get()->toArray()[0] ?? null,
                 'nombres'=> $nombres ?? null,
                 'roles' => $this->persona()->with('roles')->get()->toArray()[0]['roles'] ?? null,                 
             ]);
         }
     }
     public function setPasswordAttribute($password)
     {
         $this->attributes['password'] = Hash::make($password);
     }
 
     public static function getPersonasUsuarios()
     {
         $id_rolUsuario = '1';
         $personas = Persona::whereHas('roles', function ($query) use ($id_rolUsuario) {
             $query->where('rol.id', '=', $id_rolUsuario);
         })->get();
         return $personas;
     }

     /**
     * Función para listar Usuarios
     *
     * @param  model $query
     * @param  string $login
     * @param  string $nombre
     * @param  int $tipousuario
     * @return sql 
     */
    public function scopelistar($query, $login, $nombre = null, $tipousuario_id = null)
    {
        return $query->join('persona', 'persona.id', '=', 'usuario.persona_id')

            ->where(function ($subquery) use ($login) {
                if (!is_null($login)) {
                    $subquery->where('login', 'LIKE', '%' . $login . '%');
                }
            })
            ->where(function ($subquery) use ($nombre) {
                if (!is_null($nombre)) {
                    $subquery->where(DB::raw('concat(persona.apellidopaterno,\' \',persona.apellidomaterno,\' \',persona.nombres)'), 'LIKE', '%' . $nombre . '%');
                }
            })
            ->where(function ($subquery) use ($tipousuario_id) {
                if (!is_null($tipousuario_id)) {
                    $subquery->where('tipousuario_id', '=', $tipousuario_id);
                }
            })                    
            ->select('usuario.*', 'persona.nombres', 'persona.apellidopaterno', 'persona.apellidomaterno')->orderBy('persona.apellidopaterno', 'asc');
    }
}

