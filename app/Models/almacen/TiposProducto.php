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
        'descripcion',
        'deleted_at'
    ];

    public function categorias(){
        return $this->hasMany(Categoria::class, 'idtipo_producto');
    }

    public function getTableName(){
        return $this->table;
    }
}