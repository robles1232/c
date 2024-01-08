<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnidadMedida extends Model
{
    use SoftDeletes;

    protected $table        = "unidades_medida";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'abreviatura',
        'unidad',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function productos(){
        return $this->hasMany(Producto::class, 'idunidad_medida');
    }
}
