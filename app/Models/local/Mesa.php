<?php

namespace App\Models\local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Mesa extends Model
{
    use SoftDeletes;

    protected $table        = "mesas";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'sitios',
        'estado', //1 == libre || 2 == ocupado
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }
}