<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    public $connection = 'pgsql';
    protected $table = 'tipodocumento';
    protected $primaryKey = 'idtipodocumento';
}
