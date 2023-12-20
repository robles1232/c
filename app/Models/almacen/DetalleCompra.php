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
        'tipo_presentacion', // 1 == UNITARIO || 2 == OTRAS PRESENTACIONES
        'idpresentacion_producto',
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

    public function presentacion_producto(){
        return $this->hasMany(PresentacionProducto::class, 'idpresentacion_producto');
    }
}