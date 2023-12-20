<?php

namespace App\Models\local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Plato extends Model
{
    use SoftDeletes;

    protected $table        = "platos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function detalle(){
        return $this->hasMany(PlatoDetalle::class, 'idplato');
    }
}