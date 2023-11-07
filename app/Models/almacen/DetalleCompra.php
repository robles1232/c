<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DetalleCompra extends Model
{
    use SoftDeletes;

    protected $table        = "detalle_compra";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idcompra',
        'idproducto',
        'cantidad',
        'precio_unit',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'idproducto');
    }

    public function compra(){
        return $this->belongsTo(Compra::class, 'idcompra');
    }
}