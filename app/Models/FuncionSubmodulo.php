<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FuncionSubmodulo extends Model
{
    use SoftDeletes;

    protected $table        = "funcion_submodulo";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idsubmodulo',
        'idfuncion',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function funcion(){
        return $this->belongsTo(Funcion::class, 'idfuncion');
    }
}
