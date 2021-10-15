<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Impresora extends Model
{
    public $connection = 'pgsql';
    protected $table = 'impresora';
    protected $primaryKey = 'idimpresora';
}
