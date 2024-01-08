<?php

namespace App\Models\almacen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CompraCredito extends Model
{
    use SoftDeletes;

    protected $table        = "compra_credito";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idcompra',
        'letra',
        'fecha_pago',
        'deleted_at'
    ];

    public function getTableName(){
        return $this->table;
    }

    public function compra(){
        return $this->belongsTo(Compra::class, 'idcompra');
    }
}