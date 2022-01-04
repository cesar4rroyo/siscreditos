<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banco extends Model
{
    use SoftDeletes;
    protected $table = 'banco';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'cuenta',
        'moneda',
    ];

    /**
     * Función para listar BANCO
     *
     * @param  model $query
     * @param  string $nomber
     * @return sql 
     */
    public function scopelistar($query, $nombre)
    {
        return $query->where(function ($subquery) use ($nombre) {
            if (!is_null($nombre)) {
                    $subquery->where('banco.nombre', 'LIKE', '%' . $nombre . '%');
                }
            })
            ->orderBy('nombre', 'ASC');        
    }
}
