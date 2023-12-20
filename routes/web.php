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
use App\Http\Controllers\almacen\PresentacionProductosController;
use App\Http\Controllers\local\MesaController;
use App\Http\Controllers\local\PlatoController;
use App\Http\Controllers\local\SeccionCartaController;
use App\Http\Controllers\local\CartaController;

Route::get('/', function () {
    return redirect('login');
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

    /** ------------- ALMACEN-MARCAS */
    Route::resource('presentacion_productos', PresentacionProductosController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('presentacion_productos/grilla/', [PresentacionProductosController::class, 'grilla'])->name('presentacion_productos.grilla');

    /** ------------- ALMACEN-PROVEDORES */
    Route::resource('proveedores', ProveedorController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('proveedores/grilla/', [ProveedorController::class, 'grilla'])->name('proveedores.grilla');
    Route::get('proveedores/buscar/{search}', [ProveedorController::class, 'buscar'])->name('proveedores.buscar');

    /** ------------- ALMACEN-PRODUCTOS */
    Route::resource('productos', ProductosController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('productos/grilla/', [ProductosController::class, 'grilla'])->name('productos.grilla');
    Route::get('productos/buscar/{search}', [ProductosController::class, 'buscar'])->name('productos.buscar');
    Route::get('productos/buscar_carta/{search}', [ProductosController::class, 'buscar_carta'])->name('productos.buscar_carta');

    /** ------------- ALMACEN-COMPRAS */
    Route::resource('compras', ComprasController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('compras/grilla/', [ComprasController::class, 'grilla'])->name('compras.grilla');

    /**---------------LOCAL - MESAS */
    Route::resource('mesas', MesaController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('mesas/grilla/', [MesaController::class, 'grilla'])->name('mesas.grilla');

    /**---------------LOCAL - PLATOS */
    Route::resource('platos', PlatoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('platos/grilla/', [PlatoController::class, 'grilla'])->name('platos.grilla');
    Route::get('platos/buscar_carta/{search}', [PlatoController::class, 'buscar_carta'])->name('platos.buscar_carta');


    /**---------------LOCAL - SECCIÓN CARTA */
    Route::resource('seccion_carta', SeccionCartaController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('seccion_carta/grilla/', [SeccionCartaController::class, 'grilla'])->name('seccion_carta.grilla');
    Route::get('seccion_carta/buscar/{search}', [SeccionCartaController::class, 'buscar'])->name('seccion_carta.buscar');

    /**---------------LOCAL - CARTA */
    Route::resource('cartas', CartaController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::get('cartas/grilla/', [CartaController::class, 'grilla'])->name('cartas.grilla');
});
