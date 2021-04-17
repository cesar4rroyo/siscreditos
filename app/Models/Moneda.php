<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'moneda';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion', 'nombre', 'preciocompra', 'precioventa', 'codigo'];
}
