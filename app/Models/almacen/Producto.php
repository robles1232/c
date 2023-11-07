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
        'idcategoria',
        'idmarca',
        'idunidad_medida',
        'descripcion',
        'stock',
        'precio_venta',
        'venta_directa',
        'por_defecto',
        'deleted_at'
    ];

    public function tipo_producto(){
        return $this->belongsTo(TiposProducto::class, 'idtipo_producto');
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'idcategoria');
    }

    public function marca(){
        return $this->belongsTo(Marca::class, 'idmarca');
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class, 'idunidad_medida');
    }

    public function getTableName(){
        return $this->table;
    }
}