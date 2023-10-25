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
        'unidad',
        'desagregado',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }
}
