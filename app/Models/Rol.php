<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'rol';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion'];

    public function persona()
    {
        return $this->belongsToMany(Persona::class, 'rolpersona');
    }
}
