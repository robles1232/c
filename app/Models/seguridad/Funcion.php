<?php

namespace App\Models\seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcion extends Model
{
    use SoftDeletes;

    protected $table        = "funciones";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'funcion',
        'clase',
        'icono',
        'orden',
        'boton',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }
}
