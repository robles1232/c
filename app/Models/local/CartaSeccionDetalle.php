<?php

namespace App\Models\local;

use App\Models\almacen\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CartaSeccionDetalle extends Model
{
    use SoftDeletes;

    protected $table        = "carta_seccion_detalle";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idcarta_seccion',
        'tipo', // 1 == plato || 2 = producto 
        'idplato',
        'idproducto',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function carta_seccion(){
        return $this->belongsTo(CartaSeccion::class, 'idcarta_seccion');
    }

    public function plato(){
        return $this->belongsTo(Plato::class, 'idplato');

    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}