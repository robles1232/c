<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\seguridad\AccesosController;
use App\Http\Controllers\seguridad\EmpleadoController;
use App\Http\Controllers\seguridad\FuncionController;
use App\Http\Controllers\seguridad\ModuloController;
use App\Http\Controllers\seguridad\RolController;
use App\Http\Controllers\seguridad\SubmoduloController;
use App\Http\Controllers\seguridad\UsuarioController;

use App\Http\Controllers\almacen\UnidadesMedidaController;
use App\Http\Controllers\almacen\TiposProductoController;
use App\Http\Controllers\almacen\MarcasController;
use App\Http\Controllers\almacen\ProveedorController;
use App\Http\Controllers\almacen\ProductosController;
use App\Http\Controllers\almacen\ComprasController;

use App\Http\Controllers\local\MesasController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    /** ------------- SEGURIDAD-FUNCIONES */
    Route::resource('funciones', FuncionController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('funciones/grilla/', [FuncionController::class, 'grilla'])->name('funciones.grilla');

    /** ------------- SEGURIDAD-MÓDULOS */
    Route::resource('modulos', ModuloController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('modulos/grilla/', [ModuloController::class, 'grilla'])->name('modulos.grilla');

    /** ------------- SEGURIDAD-MÓDULOS */
    Route::resource('submodulos', SubmoduloController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('submodulos/grilla/', [SubmoduloController::class, 'grilla'])->name('submodulos.grilla');

    /** ------------- SEGURIDAD-ROLES */
    Route::resource('roles', RolController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('roles/grilla/', [RolController::class, 'grilla'])->name('roles.grilla');

    /** ------------- SEGURIDAD-EMPLEADOS */
    Route::resource('empleados', EmpleadoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('empleados/grilla/', [EmpleadoController::class, 'grilla'])->name('empleados.grilla');

    /** ------------- SEGURIDAD-USUARIOS */
    Route::resource('usuarios', UsuarioController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('usuarios/grilla/', [UsuarioController::class, 'grilla'])->name('usuarios.grilla');

    /** ------------- SEGURIDAD-ACCESOS */
    Route::resource('accesos', AccesosController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('accesos/grilla/', [AccesosController::class, 'grilla'])->name('accesos.grilla');
    Route::get('accesos/acceso', [AccesosController::class, 'acceso'])->name('accesos.acceso');

    /** ------------- ALMACEN-UNIDADES DE MEDIDA */
    Route::resource('unidades_medida', UnidadesMedidaController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('unidades_medida/grilla/', [UnidadesMedidaController::class, 'grilla'])->name('unidades_medida.grilla');

    Route::resource('tipos_producto', TiposProductoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('tipos_producto/grilla/', [TiposProductoController::class, 'grilla'])->name('tipos_producto.grilla');
    Route::get('tipos_producto/getCategoria/{idtipo_producto}', [TiposProductoController::class, 'getCategoria'])->name('tipos_producto.getCategoria');

    /** ------------- ALMACEN-MARCAS */
    Route::resource('marcas', MarcasController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('marcas/grilla/', [MarcasController::class, 'grilla'])->name('marcas.grilla');

    /** ------------- ALMACEN-PROVEDORES */
    Route::resource('proveedores', ProveedorController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('proveedores/grilla/', [ProveedorController::class, 'grilla'])->name('proveedores.grilla');
    Route::get('proveedores/buscar/{search}', [ProveedorController::class, 'buscar'])->name('proveedores.buscar');

    /** ------------- ALMACEN-PRODUCTOS */
    Route::resource('productos', ProductosController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('productos/grilla/', [ProductosController::class, 'grilla'])->name('productos.grilla');
    Route::get('productos/buscar/{search}', [ProductosController::class, 'buscar'])->name('productos.buscar');

    /** ------------- ALMACEN-COMPRAS */
    Route::resource('compras', ComprasController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('compras/grilla/', [ComprasController::class, 'grilla'])->name('compras.grilla');

    /**---------------LOCAL - MESAS */
    Route::resource('mesas', MesasController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('mesas/grilla/', [MesasController::class, 'grilla'])->name('mesas.grilla');
});
