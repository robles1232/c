<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    protected $table        = "empleados";
    protected $primaryKey   = "id";

    protected $fillable = [
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'nombre_completo',
        'email',
        'telefono',
        'deleted_at'  
    ];

    public function getTableName(){
        return $this->table;
    }
    
    public function user(){
        return $this->hasOne(User::class, 'idempleado');
    }
}