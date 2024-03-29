<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposProducto extends Model
{
    use SoftDeletes;

    protected $table        = "tipos_producto";
    protected $primaryKey   = "id";

    protected $fillable = [
        'tipo',
        'descripcion',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function productos(){
        return $this->hasMany(Producto::class, 'idtipo_producto');
    }
}