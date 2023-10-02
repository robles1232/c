<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accesos extends Model
{
    use SoftDeletes;

    protected $table        = "accesos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'idsubmodulo',
        'idrol',
        'deleted_at'  
    ];

    public function getTableName(){
        return $this->table;
    }
}
