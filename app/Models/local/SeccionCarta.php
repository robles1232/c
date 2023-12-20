<?php

namespace App\Models\local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SeccionCarta extends Model
{
    use SoftDeletes;

    protected $table        = "seccion_carta";
    protected $primaryKey   = "id";

    protected $fillable = [
        'descripcion',
        'orden',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }
}