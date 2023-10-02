<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'idempleado',
        'idrol',
        'user',
        'password_change',
        'avatar',
        'deleted_at'
    ];

    protected $hidden = [
        'password',
    ];

    public function getTableName(){
        return $this->table;
    }
    
    public function empleado(){
        return $this->belongsTo(Empleado::class, 'idempleado');
    }

    public function rol(){
        return $this->belongsTo(Role::class, 'idrol');
    }
}