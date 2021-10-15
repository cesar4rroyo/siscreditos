<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    public $connection = 'pgsql';
    protected $table = 'unidad';
    protected $primaryKey = 'idunidad';
}
