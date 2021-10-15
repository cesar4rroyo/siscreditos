<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $connection = 'pgsql';
    protected $table = 'producto';
    protected $primaryKey = 'idproducto';

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'idunidadbase');
    }
    public function impresora()
    {
        return $this->belongsTo(Impresora::class, 'idimpresora');
    }
}
