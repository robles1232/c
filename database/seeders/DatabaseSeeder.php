<?php

namespace Database\Seeders;

use App\Models\Accesos;
use App\Models\Empleado;
use App\Models\Funcion;
use App\Models\FuncionSubmodulo;
use App\Models\Modulo;
use App\Models\Submodulo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
                
        //--------------ROLES
        $role = Role::create(["name" => 'Admin']);

        //---------- FUNCIONES 
        $funcion = new Funcion();
        $funcion->descripcion = "Listar";
        $funcion->funcion     = "index";
        $funcion->save();

        $funcion = new Funcion();
        $funcion->descripcion = "Crear";
        $funcion->funcion     = "create";
        $funcion->clase       = 'btn btn-outline-primary';
        $funcion->icono       = 'fe fe-plus-circle';
        $funcion->orden       = 1;
        $funcion->boton       = true;
        $funcion->save();

        $funcion = new Funcion();
        $funcion->descripcion = "Editar";
        $funcion->funcion     = "edit";
        $funcion->clase       = 'btn btn-outline-warning';
        $funcion->icono       = 'fe fe-edit';
        $funcion->orden       = 2;
        $funcion->boton       = true;
        $funcion->save();

        $funcion = new Funcion();
        $funcion->descripcion = "Elim/Rest";
        $funcion->funcion     = "destroy";
        $funcion->clase       = 'btn btn-outline-default';
        $funcion->icono       = 'fe fe-circle';
        $funcion->orden       = 3;
        $funcion->boton       = true;
        $funcion->save();

        $funcion = new Funcion();
        $funcion->descripcion = "Guardar";
        $funcion->funcion     = "store";
        $funcion->save();

        //------------------- MODULOS
        $modulo = new Modulo();
        $modulo->descripcion = "Seguridad";
        $modulo->abreviatura = "Seg";
        $modulo->icono       = "ti-lock";
        $modulo->orden       = 1;
        $modulo->save();

        //----------------- Submodulos
        /**FUNCIÓN */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = 1;
        $submodulo->descripcion = "Funciones";
        $submodulo->abreviatura = "Func";
        $submodulo->url         = "funciones";
        $submodulo->orden       = 1;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /**MODULOS */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = 1;
        $submodulo->descripcion = "Módulos";
        $submodulo->abreviatura = "Mod";
        $submodulo->url         = "modulos";
        $submodulo->orden       = 2;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /** SUBMODULO */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = 1;
        $submodulo->descripcion = "Submódulos";
        $submodulo->abreviatura = "Subm";
        $submodulo->url         = "submodulos";
        $submodulo->orden       = 3;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /** ROLES */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = 1;
        $submodulo->descripcion = "Roles";
        $submodulo->abreviatura = "Rol";
        $submodulo->url         = "roles";
        $submodulo->orden       = 4;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /** EMPLEADOS */
        $submodulo = new Submodulo();
        $submodulo->idmodulo    = 1;
        $submodulo->descripcion = "Empleados";
        $submodulo->abreviatura = "Emp";
        $submodulo->url         = "empleados";
        $submodulo->orden       = 5;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /**USUARIOS */

        $submodulo = new Submodulo();
        $submodulo->idmodulo    = 1;
        $submodulo->descripcion = "Usuarios";
        $submodulo->abreviatura = "Usr";
        $submodulo->url         = "usuarios";
        $submodulo->orden       = 6;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 2;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 3;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 4;
        $funcion_submodulo->save();

        /** Accesos */

        $submodulo = new Submodulo();
        $submodulo->idmodulo    = 1;
        $submodulo->descripcion = "Accesos";
        $submodulo->abreviatura = "Acc";
        $submodulo->url         = "accesos";
        $submodulo->orden       = 7;
        $submodulo->save();

        $accesos = new Accesos();
        $accesos->idsubmodulo = $submodulo->id;
        $accesos->idrol = 1;
        $accesos->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 1;
        $funcion_submodulo->save();

        $funcion_submodulo = new FuncionSubmodulo();
        $funcion_submodulo->idsubmodulo = $submodulo->id;;
        $funcion_submodulo->idfuncion   = 5;
        $funcion_submodulo->save();


        //---------- ROLES
        /*Permission::create(["name" => 'home'])->syncRoles([$role]);
        Permission::create(["name" => 'funciones-index'])->syncRoles([$role]);
        Permission::create(["name" => 'modulos-create'])->syncRoles([$role]);
        Permission::create(["name" => 'modulos-edit'])->syncRoles([$role]);
        Permission::create(["name" => 'modulos-destroy'])->syncRoles([$role]);
        Permission::create(["name" => 'modulos-restore'])->syncRoles([$role]);*/



        $empleado = new Empleado();
        $empleado->dni = '11111111';
        $empleado->nombres = 'Isaias';
        $empleado->apellido_paterno = 'Lopez';
        $empleado->apellido_materno = 'Burga';
        $empleado->nombre_completo = 'Isaias Lopez Burga';
        $empleado->email = 'admin@gmail.com';
        $empleado->telefono = '999888777';
        $empleado->save();

        $user = new User();
        $user->idempleado = $empleado->id;
        $user->idrol = $role->id;
        $user->user = 'admin';
        $user->password = Hash::make('admin');
        $user->save();
        //$user->assignRole($role);

        $permisos = [
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
        ];
        
        foreach($permisos as $permiso){
            Permission::create(['name' => $permiso]);
        }

        $permisos = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permisos);
        $user->assignRole($role->id);
    }
}
