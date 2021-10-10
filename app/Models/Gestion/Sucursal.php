<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    public $connection = 'pgsql';
    protected $table = 'sucursal';
    protected $primaryKey = 'idsucursal';
}
