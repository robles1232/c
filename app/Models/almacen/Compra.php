<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Compra extends Model
{
    use SoftDeletes;

    protected $table        = "compras";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idproveedor',
        'tipo_comprobante',
        'serie_comprobante',
        'numero_comprobante',
        'fecha_compra',
        'igv',
        'hay_descuento',
        'descuento',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'idproveedor');
    }
    public function detalle_compra(){
        return $this->hasMany(DetalleCompra::class, 'idcompra');
    }
}