<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class ConceptoPago extends Model
{
    public $connection = 'pgsql';
    protected $table = 'conceptopago';
    protected $primaryKey = 'idconceptopago';

}
