<?php

namespace App\Models\local;

use App\Models\almacen\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PlatoDetalle extends Model
{
    use SoftDeletes;

    protected $table        = "plato_detalle";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idplato',
        'idproducto',
        'cantidad',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function plato(){
        return $this->belongsTo(Plato::class, 'idplato');
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'idproducto');
    }
}