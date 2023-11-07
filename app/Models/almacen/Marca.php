<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Marca extends Model
{
    use SoftDeletes;

    protected $table        = "marcas";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }
}