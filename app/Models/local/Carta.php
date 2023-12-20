<?php

namespace App\Models\local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Carta extends Model
{
    use SoftDeletes;

    protected $table        = "cartas";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'estado', // 1 == Inactivo || 2 == carta actual
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function secciones(){
        return $this->hasMany(CartaSeccion::class, 'idcarta');
    }
}