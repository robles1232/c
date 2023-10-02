<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermisos extends Model
{

    protected $table        = "role_permisos";
    protected $primaryKey   = "id";

    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    public function getTableName(){
        return $this->table;
    }
}