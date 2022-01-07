<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public $connection = 'pgsql';
    protected $table = 'persona';
    protected $primaryKey = 'idpersona';

    use \Awobaz\Compoships\Compoships;


    public function personamaestro()
    {
        return $this->belongsTo(PersonaMaestro::class, ['idpersonamaestro', 'idsucursal'], ['idpersonamaestro', 'idsucursal']);
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
}
