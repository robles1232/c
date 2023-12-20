<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PresentacionProducto extends Model
{
    use SoftDeletes;

    protected $table        = "presentacion_productos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idunidad_medida',
        'descripcion',
        'cantidad',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function unidad_medida(){
        return $this->belongsTo(UnidadMedida::class, 'idunidad_medida');
    }
}