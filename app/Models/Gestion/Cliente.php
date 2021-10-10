<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $connection = 'pgsql';
    protected $table = 'persona';
    protected $primaryKey = 'idpersona';

    public function personamaestro()
    {
        return $this->belongsTo(PersonaMaestro::class, 'idpersonamaestro');
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
}
