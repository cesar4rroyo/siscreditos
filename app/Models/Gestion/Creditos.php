<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Creditos extends Model
{
    public $connection = 'pgsql';
    protected $table = 'ventacredito';
    protected $primaryKey = 'idventacredito';
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idsucursal');
    }
    public function pagos()
    {
        return $this->hasMany(Pagos::class, 'idventacredito');
    }
    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'idmovimiento');
    }
    public function scopelistar($query, $fecinicio, $fecfin, $nombre, $sucursal, $estado, $pedidosYa)
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
            ->where(function ($subquery) use ($estado) {
                if (!is_null($estado) && strlen($estado) > 0) {
                    $subquery->where('estado',  $estado);
                }
            })
            ->where(function ($subquery) use ($pedidosYa) {
                if (!is_null($pedidosYa) && strlen($pedidosYa) > 0) {
                    $subquery->whereHas('movimiento', function ($q2) use ($pedidosYa) {
                        $q2->whereHas('mesa', function ($q3) use ($pedidosYa) {
                            $q3->whereIn('idsalon', [9,10]);
                        });
                    });
                }
            })
            ->orderBy('fecha_consumo', 'DESC');
    }
}
