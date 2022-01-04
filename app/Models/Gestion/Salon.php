<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    public $connection = 'pgsql';
    protected $table = 'salon';
    protected $primaryKey = 'idsalon';
}
