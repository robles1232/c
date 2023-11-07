<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    protected $table        = "categorias";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idtipo_producto',
        'descripcion',
        'deleted_at'
    ];

    public function tipo_producto(){
        return $this->belongsTo(TiposProducto::class, 'idtipo_producto');
    }
    
    public function getTableName(){
        return $this->table;
    }
}