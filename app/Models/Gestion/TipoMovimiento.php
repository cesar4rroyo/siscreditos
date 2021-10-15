<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    public $connection = 'pgsql';
    protected $table = 'tipomovimiento';
    protected $primaryKey = 'idtipomovimiento';
}
