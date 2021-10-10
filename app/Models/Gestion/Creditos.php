<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Creditos extends Model
{
    public $connection = 'pgsql';
    protected $table = 'ventacredito';
    protected $primaryKey = 'idventacredito';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
}

