<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagos extends Model
{
    use SoftDeletes;
    public $connection = 'mysql';
    protected $table = 'pagos';
    protected $primaryKey = 'id';
    protected $fillable = ['idventacredito', 'monto', 'fechapago', 'comentario', 'idsucursal'];

    public function creditos()
    {
        return $this->belongsTo(Creditos::class, 'creditos_id');
    }
}
