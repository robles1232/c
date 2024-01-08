<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $table        = "productos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idtipo_producto', 
        'tipo', // 1 == ingrediente || 2 == producto
        'idunidad_medida',
        'descripcion',
        'stock',
        'precio_venta',
        'por_defecto',
        'deleted_at'
    ];

    public function tipo_producto(){
        return $this->belongsTo(TiposProducto::class, 'idtipo_producto');
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class, 'idunidad_medida');
    }

    public function presentaciones_producto(){
        return $this->hasMany(PresentacionesProducto::class, 'idproducto');
    }

    public function getTableName(){
        return $this->table;
    }
}