<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    public $connection = 'pgsql';
    protected $table = 'mesa';
    protected $primaryKey = 'idmesa';

    public function salon()
    {
        return $this->belongsTo(Salon::class, 'idsalon');
    }
}
