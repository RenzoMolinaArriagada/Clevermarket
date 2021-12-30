<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IntegracionesController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\FidelizacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
/
/
/
/
*/
/**
*@group Paginas principales
*
*/
Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/productos/{clase}/',[TiendaController::class,'mostrarProductos'])->name('productos.mostrar');

Route::get('/productos/{clase}/{producto}',[TiendaController::class,'vistaProducto'])->name('productos.vistaProducto');

Route::get('/administracion/',[AdminController::class,'index'])->name('admin');

/**
*@group Dashboard y Reportabilidad
*
*/
Route::get('/administracion/descargaProductosVendidos/',[AdminController::class,'descargaProductosVendidos'])->name('admin.descargaProductosVendidos');

/**
*@group Perfil Usuario
*
*/
Route::get('/perfil/{usuario}',[UserController::class,'perfil'])->name('user.perfil');
Route::get('/perfil/{usuario}/editar',[UserController::class,'formEditPerfil'])->name('user.formEditPerfil');
Route::patch('/perfil/{usuario}/editar',[UserController::class,'updateUser'])->name('user.updateUser');


/**
*@group Mantenedor de productos
*
*/
Route::get('/administracion/productos/{clase}/',[AdminController::class,'mantenedorProductos'])->name('admin.manProductos');
Route::patch('/administracion/productos/{clase}/',[AdminController::class,'activadorProductos'])->name('admin.activadorProductos');
Route::patch('/administracion/productos/{clase}/cantidad',[AdminController::class,'cantidadProductos'])->name('admin.cantidadProductos');
Route::get('/administracion/productos/{clase}/nuevo_producto',[AdminController::class,'formCreateProducto'])->name('admin.formCreateProducto');
Route::post('/administracion/productos/{clase}/nuevo_producto',[AdminController::class,'createProducto'])->name('admin.createProducto');
Route::get('/administracion/productos/{clase}/{producto}/edit',[AdminController::class,'formEditProducto'])->name('admin.formEditProducto');
Route::patch('/administracion/productos/{clase}/{producto}/edit',[AdminController::class,'updateProducto'])->name('admin.updateProducto');
Route::get('/administracion/carga_masiva/productos',[AdminController::class,'formProductoMasivo'])->name('admin.formProductoMasivo');
Route::post('/administracion/carga_masiva/productos/revision',[AdminController::class,'setProductoMasivo'])->name('admin.setProductoMasivo');
Route::post('/administracion/carga_masiva/productos/carga',[AdminController::class,'createProductoMasivo'])->name('admin.createProductoMasivo');
/**
*@group Mantenedores del sistema
*
*/
Route::get('/administracion/mantenedores/clases',[AdminController::class,'mantenedorClases'])->name('admin.manClases');
Route::patch('/administracion/mantenedores/clases',[AdminController::class,'activadorClases'])->name('admin.activadorClases');
Route::get('/administracion/mantenedores/clases/nueva_clase',[AdminController::class,'formCreateClase'])->name('admin.formCreateClase');
Route::post('/administracion/mantenedores/clases/nueva_clase',[AdminController::class,'createClase'])->name('admin.createClase');
Route::get('/administracion/mantenedores/clases/{clase}',[AdminController::class,'formEditClase'])->name('admin.formEditClase');
Route::patch('/administracion/mantenedores/clases/{clase}',[AdminController::class,'updateClase'])->name('admin.updateClase');

Route::get('/administracion/mantenedores/usuarios',[AdminController::class,'mantenedorUsuarios'])->name('admin.manUsuarios');
Route::patch('/administracion/mantenedores/usuarios/',[AdminController::class,'activadorUsuarios'])->name('admin.activadorUsuarios');
Route::get('/administracion/mantenedores/usuarios/nuevo',[AdminController::class,'formCreateUsuario'])->name('admin.formCreateUsuario');
Route::post('/administracion/mantenedores/usuarios/nuevo',[AdminController::class,'createUsuario'])->name('admin.createUsuario');
Route::get('/administracion/mantenedores/usuarios/{usuario}',[AdminController::class,'formEditUsuario'])->name('admin.formEditUsuario');
Route::post('/administracion/mantenedores/usuarios/{usuario}',[AdminController::class,'updateUsuario'])->name('admin.updateUsuario');
//Mantenedor para Marcas
Route::get('/administracion/mantenedores/marcas',[AdminController::class,'mantenedorMarcas'])->name('admin.manMarcas');
Route::patch('/administracion/mantenedores/marcas',[AdminController::class,'activadorMarcas'])->name('admin.activadorMarcas');
Route::get('/administracion/mantenedores/marcas/nueva_marca',[AdminController::class,'formCreateMarca'])->name('admin.formCreateMarca');
Route::post('/administracion/mantenedores/marcas/nueva_marca',[AdminController::class,'createMarca'])->name('admin.createMarca');
Route::get('/administracion/mantenedores/marcas/{marca}',[AdminController::class,'formEditMarca'])->name('admin.formEditMarca');
Route::patch('/administracion/mantenedores/marcas/{marca}',[AdminController::class,'updateMarca'])->name('admin.updateMarca');
//Mantenedor para Auditoria
Route::get('/administracion/mantenedores/auditoria',[AdminController::class,'mantenedorAuditoria'])->name('admin.manAudits');
//Mantenedor de Ventas
Route::get('/administracion/ventas',[AdminController::class,'mantenedorVentas'])->name('admin.manVentas');
Route::post('/administracion/ventas/despachar',[VentaController::class,'ventaDespachar'])->name('venta.ventaDespachar');
Route::post('/administracion/ventas/ventaspormes',[VentaController::class,'ventasPorMes'])->name('venta.ventasPorMes');
Route::post('/perfil/{usuario}',[VentaController::class,'ventaRecibido'])->name('venta.setRecibido');

/**
*@group Mantenedores para personalizacion
*
*/
Route::get('/administracion/personalizacion',[AdminController::class,'mantenedorPersonalizacion'])->name('admin.manPersonalizacion');
Route::post('/administracion/personalizacion/banner',[AdminController::class,'cambiarBanner'])->name('custom.cambiarBanner');
Route::post('/administracion/personalizacion/logo',[AdminController::class,'cambiarLogo'])->name('custom.cambiarLogo');
Route::post('/administracion/personalizacion/color',[AdminController::class,'cambiarColorBtns'])->name('custom.cambiarColorBtns');

/**
*@group Mantenedor de Compras
*
*/
Route::post('/compra/carro/',[CarroController::class,'agregarAlCarro'])->name('carro.agregar');
Route::patch('/compra/carro/',[CarroController::class,'modificarCantidad'])->name('carro.modificarCantidad');
Route::get('/compra/carro/',[CarroController::class,'verCarro'])->name('compra.verCarro');
Route::get('/compra/datos/',function () {
    return redirect('/compra/carro/');
});
Route::post('/compra/datos/',[CarroController::class,'solicitaDatos'])->name('compra.verDatos');
Route::post('/compra/datos/detalle',[VentaController::class,'ingresarCompra'])->name('compra.ingresarCompra');
Route::post('/compra/datos/verificar_codigo_descuento',[VentaController::class,'verificarCodigoDescuento'])->name('compra.verificarCodigo');

/**
*@group Marketing
*
*/
Route::get('/administracion/marketing/publicidad',[MarketingController::class,'panelPublicidad'])->name('admin.emailPublicidad');
Route::get('/administracion/marketing/publicidad/nuevo',[MarketingController::class,'formCreateMailPub'])->name('mark.formCreateMailPub');
Route::post('/administracion/marketing/publicidad/nuevo',[MarketingController::class,'createMailPub'])->name('mark.createMailPub');
Route::get('/administracion/marketing/publicidad/edit/{mailing}',[MarketingController::class,'formEditMailPub'])->name('mark.formEditMailPub');
Route::post('/administracion/marketing/publicidad/edit/{mailing}',[MarketingController::class,'editMailPub'])->name('mark.editMailPub');
Route::get('/administracion/marketing/publicidad/send/{mailing}',[MarketingController::class,'formSendMailing'])->name('mark.formSendMailing');
Route::post('/administracion/marketing/publicidad/send/',[MarketingController::class,'sendMailing'])->name('mark.sendMailing');
Route::get('/administracion/marketing/encuestas',[MarketingController::class,'panelEncuestas'])->name('admin.emailEncuestas');
Route::get('/administracion/marketing/encuestas/nuevo',[MarketingController::class,'formCreateEncuesta'])->name('mark.formCreateEncuesta');
Route::post('/administracion/marketing/encuestas/nuevo',[MarketingController::class,'createEncuesta'])->name('mark.createEncuesta');


/**
*@group Fidelizacion
*
*/
Route::get('/administracion/fidelizacion/codigosdescuento',[FidelizacionController::class,'manCodigosDescuento'])->name('fid.manCodigosDescuento');
Route::get('/administracion/fidelizacion/codigosdescuento/nuevo',[FidelizacionController::class,'formCreateCodigoDescuento'])->name('fid.formCreateCodigoDescuento');
Route::post('/administracion/fidelizacion/codigosdescuento/nuevo',[FidelizacionController::class,'createCodigoDescuento'])->name('fid.createCodigoDescuento');
Route::get('/administracion/fidelizacion/codigosdescuento/edit/{codigo}',[FidelizacionController::class,'formEditCodigoDescuento'])->name('fid.formEditCodigoDescuento');
Route::post('/administracion/fidelizacion/codigosdescuento/edit/{codigo}',[FidelizacionController::class,'editCodigoDescuento'])->name('fid.editCodigoDescuento');

/**
*@group Integraciones
*
*/
Route::get('/administracion/integraciones/',[AdminController::class,'panelIntegraciones'])->name('admin.panelIntegraciones');
Route::get('/administracion/integraciones/DatosMercadoLibre',[IntegracionesController::class,'formDatosMercadoLibre'])->name('int.formDatosML');
Route::post('/administracion/integraciones/DatosMercadoLibre',[IntegracionesController::class,'setDatosMercadoLibre'])->name('int.setDatosML');
Route::post('/administracion/integraciones/mercadoLibreToken',[IntegracionesController::class,'getMercadoLibreToken'])->name('int.getTokenML');
Route::get('/administracion/integraciones/DatosChilexpress',[IntegracionesController::class,'formDatosChilexpress'])->name('int.formDatosChE');
Route::post('/administracion/integraciones/DatosChilexpress',[IntegracionesController::class,'setDatosChilexpress'])->name('int.setDatosChE');
Route::get('/administracion/integraciones/DatosBluexpress',[IntegracionesController::class,'formDatosBluexpress'])->name('int.formDatosBlE');
Route::post('/administracion/integraciones/DatosBluexpress',[IntegracionesController::class,'setDatosBluexpress'])->name('int.setDatosBlE');

require __DIR__.'/auth.php';