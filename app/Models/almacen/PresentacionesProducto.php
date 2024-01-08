<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PresentacionesProducto extends Model
{
    use SoftDeletes;

    protected $table        = "presentaciones_producto";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idproducto',
        'idpresentacion_producto',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'idproducto');
    }

    public function presentacion(){
        return $this->belongsTo(PresentacionProducto::class, 'idpresentacion_producto');
    }
}