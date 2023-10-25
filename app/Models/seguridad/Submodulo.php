<?php

namespace App\Models\seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submodulo extends Model
{
    use SoftDeletes;

    protected $table        = "submodulos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idmodulo',
        'descripcion',
        'abreviatura',
        'url',
        'orden',
        'icono',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function modulo(){
        return $this->belongsTo(Modulo::class, 'idmodulo');
    }

    public function funciones(){
        return $this->hasMany(FuncionSubmodulo::class, 'idsubmodulo');
    }
}
