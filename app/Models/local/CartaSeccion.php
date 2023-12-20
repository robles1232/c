<?php

namespace App\Models\local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CartaSeccion extends Model
{
    use SoftDeletes;

    protected $table        = "carta_seccion";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idcarta',
        'idseccion',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function carta(){
        return $this->belongsTo(Carta::class, 'idcarta');
    }

    public function seccion(){
        return $this->belongsTo(SeccionCarta::class, 'idseccion');
    }

    public function carta_seccion_detalle(){
        return $this->hasMany(CartaSeccionDetalle::class, 'idcarta_seccion');
    }
}