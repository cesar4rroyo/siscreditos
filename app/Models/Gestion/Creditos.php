<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function scopelistar($query, $fecinicio, $fecfin, $nombre, $sucursal)
    {
        return $query
            ->where(function ($subquery) use ($fecinicio) {
                if (!is_null($fecinicio) && strlen($fecinicio) > 0) {
                    $subquery->where('fecha_consumo', '>=', date_format(date_create($fecinicio), 'Y-m-d'));
                }
            })
            ->where(function ($subquery) use ($fecfin) {
                if (!is_null($fecfin) && strlen($fecfin) > 0) {
                    $subquery->where('fecha_consumo', '<=', date_format(date_create($fecfin), 'Y-m-d'));
                }
            })
            ->where(function ($subquery) use ($nombre) {
                if (!is_null($nombre) && strlen($nombre) > 0) {
                    $subquery->whereHas('cliente', function ($q2) use ($nombre) {
                        $q2->whereHas('personamaestro', function ($q3) use ($nombre) {
                            $q3->where(DB::connection('pgsql')->raw('concat(personamaestro.nombres, \'\', personamaestro.apellidos)'), 'LIKE', '%' . $nombre . '%');
                        });
                    });
                }
            })
            ->where(function ($subquery) use ($sucursal) {
                if (!is_null($sucursal) && strlen($sucursal) > 0) {
                    $subquery->where('idsucursal',  $sucursal);
                }
            })
            ->orderBy('fecha_consumo', 'DESC');
    }
}
