<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission;

class Proveedor extends Model
{
    use SoftDeletes;

    protected $table        = "proveedores";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'ruc',
        'direccion',
        'telefono',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }
}