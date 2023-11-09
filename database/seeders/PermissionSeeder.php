<?php

namespace Database\Seeders;

use App\Models\seguridad\Empleado;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   

                
        //--------------ROLES
        $role = Role::findById(1);

        $permisos = [
            //-------------------------------SEGURIDAD
            'index-funciones',
            'create-funciones',
            'edit-funciones',
            'store-funciones',
            'destroy-funciones',

            'index-modulos',
            'create-modulos',
            'edit-modulos',
            'store-modulos',
            'destroy-modulos',

            'index-submodulos',
            'create-submodulos',
            'edit-submodulos',
            'store-submodulos',
            'destroy-submodulos',

            'index-roles',
            'create-roles',
            'edit-roles',
            'store-roles',
            'destroy-roles',

            'index-empleados',
            'create-empleados',
            'edit-empleados',
            'store-empleados',
            'destroy-empleados',

            'index-usuarios',
            'create-usuarios',
            'edit-usuarios',
            'store-usuarios',
            'destroy-usuarios',

            'index-accesos',
            'store-accesos',

            //------------------------------ALMACEN
            'index-unidades_medida',
            'create-unidades_medida',
            'edit-unidades_medida',
            'store-unidades_medida',
            'destroy-unidades_medida',

            'index-marcas',
            'create-marcas',
            'edit-marcas',
            'store-marcas',
            'destroy-marcas',

            'index-tipos_producto',
            'create-tipos_producto',
            'edit-tipos_producto',
            'store-tipos_producto',
            'destroy-tipos_producto',

            'index-proveedores',
            'create-proveedores',
            'edit-proveedores',
            'store-proveedores',
            'destroy-proveedores',

            'index-productos',
            'create-productos',
            'edit-productos',
            'store-productos',
            'destroy-productos',

            'index-compras',
            'create-compras',
            'edit-compras',
            'store-compras',
            'destroy-compras',

            //-------------------------GESTIÓN DE LOCAL
            'index-mesas',
            'create-mesas',
            'edit-mesas',
            'store-mesas',
            'destroy-mesas',

            'index-recetas',
            'create-recetas',
            'edit-recetas',
            'store-recetas',
            'destroy-recetas',

            'index-menus',
            'create-menus',
            'edit-menus',
            'store-menus',
            'destroy-menus',
        ];
        

        //EMPLEADO
        $empleado = new Empleado();
        $empleado->dni = '11111111';
        $empleado->nombres = 'Isaias';
        $empleado->apellido_paterno = 'Lopez';
        $empleado->apellido_materno = 'Burga';
        $empleado->nombre_completo = 'Isaias Lopez Burga';
        $empleado->email = 'admin@gmail.com';
        $empleado->telefono = '999888777';
        $empleado->save();


        //USUARIO
        $user = new User();
        $user->idempleado = $empleado->id;
        $user->idrol = $role->id;
        $user->user = 'admin';
        $user->password = Hash::make('admin');
        $user->save();

        foreach($permisos as $permiso){
            Permission::create(['name' => $permiso]);
        }

        $permisos = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permisos);
        $user->assignRole($role->id);
    }
}
