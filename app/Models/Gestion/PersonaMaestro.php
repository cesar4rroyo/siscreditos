<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class PersonaMaestro extends Model
{
    public $connection = 'pgsql';
    protected $table = 'personamaestro';
    protected $primaryKey = 'idpersonamaestro';
    protected $appends = ['fullname'];

    public function getFullNameAttribute() 
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
    public function getocumentAttribute() 
    {
        return $this->nrdoc;
    }
}
