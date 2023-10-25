<?php

namespace App\Models\seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

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