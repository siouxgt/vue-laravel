<?php

use App\Http\Controllers\AdjudicacionDirectaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnexosAdjudicacionController;
use App\Http\Controllers\AnexosContratoController;
use App\Http\Controllers\AnexosPublicaController;
use App\Http\Controllers\AnexosRestringidaController;
use App\Http\Controllers\BienServicioController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CarritoCompraController;
use App\Http\Controllers\CatProductoController;
use App\Http\Controllers\CatProveedorController;
use App\Http\Controllers\ContratoMarcoController;
use App\Http\Controllers\ContratoMarcoUrgController;
use App\Http\Controllers\ContratoOcUrgController;
use App\Http\Controllers\ContratosVistaController;
use App\Http\Controllers\ExpedientesContratoController;
use App\Http\Controllers\FirmantesController;
use App\Http\Controllers\GrupoRevisorController;
use App\Http\Controllers\HabilitarProductoController;
use App\Http\Controllers\HabilitarProveedoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidenciaAdminController;
use App\Http\Controllers\IncidenciaProveedorController;
use App\Http\Controllers\IncidenciaUrgController;
use App\Http\Controllers\InvitacionRestringidaController;
use App\Http\Controllers\LicitacionPublicaController;
use App\Http\Controllers\MensajeProveedorController;
use App\Http\Controllers\OrdenCompraAdminController;
use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\OrdenCompraEnvioController;
use App\Http\Controllers\OrdenCompraFacturaController;
use App\Http\Controllers\OrdenCompraPagoController;
use App\Http\Controllers\OrdenCompraProrrogaController;
use App\Http\Controllers\OrdenCompraProveedorController;
use App\Http\Controllers\OrdenCompraSustitucionController;
use App\Http\Controllers\OrdenCompraUrgController;
use App\Http\Controllers\ProductosFavoritosUrgController;
use App\Http\Controllers\ProductosPreguntasRespuestasController;
use App\Http\Controllers\ProveedorComentarioController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProveedorFichaProductoController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\ReporteAdminController;
use App\Http\Controllers\ReporteProveedorController;
use App\Http\Controllers\ReporteUrgController;
use App\Http\Controllers\RequisicioneController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SolicitudCompraController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\TiendaUrgController;
use App\Http\Controllers\UrgController;
use App\Http\Controllers\UrgGeneralController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValidacionAdministrativaController;
use App\Http\Controllers\ValidacionTecnicaController;
use App\Http\Controllers\ValidadorTecnicoController;
use Illuminate\Support\Facades\Route;


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
//admin

Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/mensajes', [AdminController::class, 'mensajes'])->name('admin.mensajes');
Route::get('/mensajes/data/{id}', [AdminController::class, 'dataMensajes'])->name('admin.mensajes_data');
Route::post('/mensajes/destacar', [AdminController::class, 'destacarMensaje'])->name('admin.mensaje_destacar');
Route::post('/mensajes/archivar', [AdminController::class, 'archivarMensaje'])->name('admin.mensaje_archivar');
Route::post('/mensajes/eliminar', [AdminController::class, 'eliminarMensaje'])->name('admin.mensaje_eliminar');
Route::post('/mensajes/leido', [AdminController::class, 'leido'])->name('admin.mensaje_leido');
Route::get('/mensajes/responder_modal/{id}', [AdminController::class, 'responderModal'])->name('admin.mensaje_responder_modal');
Route::post('mensajes/responder_save', [AdminController::class, 'responderSave'])->name('admin.mensaje_responder_save');

//incidencias admin
Route::get('/incidencias', [IncidenciaAdminController::class, 'index'])->name('incidencia_admin.index');
Route::get('/incidencias/data_urg', [IncidenciaAdminController::class, 'dataUrg'])->name('incidencia_admin.data_urg');
Route::get('incidencias/data_urg/filtro/{filtro}', [IncidenciaAdminController::class, 'dataUrgFiltro'])->name('incidencia_admin.data_urg_filtro');
Route::get('/incidencias/modal_info_proveedor/{id}', [IncidenciaAdminController::class, 'modalInfoProveedor'])->name('incidencia_admin.modal_info_proveedor');
Route::get('/incidencias/modal_respuesta', [IncidenciaAdminController::class, 'modalRespuesta'])->name('incidencia_admin.modal_respuesta');
Route::get('/incidencias/combos_respuesta/{escala}', [IncidenciaAdminController::class, 'combosRespuesta'])->name('incidencia_admin.combos_respuesta');
Route::post('/incidencias/respuesta_save', [IncidenciaAdminController::class, 'respuestaSave'])->name('incidencia_admin.respuesta_save');

Route::get('/incidencias/data_proveedor', [IncidenciaAdminController::class, 'dataProveedor'])->name('incidencia_admin.data_proveedor');
Route::get('/incidencias/data_proveedor/filtro/{filtro}', [IncidenciaAdminController::class, 'dataProveedorFiltro'])->name('incidencia_admin.data_proveedor_filtro');
Route::get('/incidencias/modal_info_urg/{id}', [IncidenciaAdminController::class, 'modalInfoUrg'])->name('incidencia_admin.modal_info_urg');

Route::get('/incidencias/data_admin', [IncidenciaAdminController::class, 'dataAdmin'])->name('incidencia_admin.data_admin');
Route::get('/incidencias/data_admin_filtro/{filtro}', [IncidenciaAdminController::class, 'dataAdminFiltro'])->name('incidencia_admin.data_admin_filtro');
Route::get('/incidencias/modal_admin_incidencia/', [IncidenciaAdminController::class, 'modalAdminIncidencia'])->name('incidencia_admin.modal_admin_incidencia');
Route::get('/incidencias/combos_usuarios/{usuario}', [IncidenciaAdminController::class, 'combosUsuarios'])->name('incidencia_admin.combos_usuarios');
Route::get('/incidencias/combos_origen/{usuario}/{origen}/{tipo}', [IncidenciaAdminController::class, 'combosIdOrigen'])->name('incidencia_admin.combos_origen');
Route::get('/data/combos_sancion/{escala}', [IncidenciaAdminController::class, 'comboSancion'])->name('incidencia_admin.combos_sancion');
Route::get('/incidencias/combos_motivo/{sancion}/{tipo}', [IncidenciaAdminController::class, 'comboMotivo'])->name('incidencia_admin.combos_motivo');
Route::post('incidencias/admin_save', [IncidenciaAdminController::class, 'saveIncidencia'])->name('incidencia_admin.save');

Auth::routes();

//catProveedor
Route::get('/data/cat_proveedor', [CatProveedorController::class, 'data'])->name('cat_proveedor.data');
Route::get('buscar/cat_proveedor/{rfc}',[CatProveedorController::class,'buscarProveedor'])->name('cat_proveedor.buscar');
Route::resource('/cat_proveedor', CatProveedorController::class);

// Calendario Subasta

// Route::get('/calendario', CalendarController::class, 'index')->name('calendario.index');
// Route::resource('/subasta', CalendarController::class);



Route::resource('/urg', UrgController::class);
Route::get('/fetchurgs/urg', [UrgController::class, 'fetchurgs'])->name('urg.fetchurgs');
Route::get('buscar/urg/{ccg}',[UrgController::class,'buscarUrg'])->name('urg.buscar_urg');
Route::get('/urg/ver_show/{id}/{dato?}', [UrgController::class, 'verShow'])->name('urg.ver_show');
Route::resource('/validacion', ValidacionTecnicaController::class);
Route::get('/data/validacion', [ValidacionTecnicaController::class, 'data'])->name('validacion.data');
Route::resource('/adjudicacion', AdjudicacionDirectaController::class);
Route::get('/data/adjudicacion', [AdjudicacionDirectaController::class, 'data'])->name('adjudicacion.data');
Route::resource('/anexos_adjudicacion', AnexosAdjudicacionController::class);
Route::get('/data/anexos_adjudicacion/{id}', [AnexosAdjudicacionController::class, 'data'])->name('anexos_adjudicacion.data');
Route::resource('/invitacion', InvitacionRestringidaController::class);
Route::resource('/anexos_invitacion', AnexosRestringidaController::class);
Route::get('/data/anexos_invitacion/{id}', [AnexosRestringidaController::class, 'data'])->name('anexos_invitacion.data');
Route::resource('/licitacion', LicitacionPublicaController::class);
Route::resource('/anexos_licitacion', AnexosPublicaController::class);
Route::get('/data/anexos_licitacion/{id}', [AnexosPublicaController::class, 'data'])->name('anexos_licitacion.data');
Route::get('contrato/responsables/{id}', [ContratoMarcoController::class, 'responsables'])->name('contrato.responsables');
Route::get('/responsablesvt/contrato', [ContratoMarcoController::class, 'responsablesvt'])->name('contrato.responsablesvt');
// Route::get('/buscarcontratosm/contrato', [ContratoMarcoController::class, 'buscarContratosM'])->name('contrato.buscarcontratosm');
Route::get('/service/contrato/{capitulo}', [ContratoMarcoController::class, 'serviceCapitulosP'])->name('contrato.service');
Route::match(['put', 'patch'], 'liberar/contrato', [ContratoMarcoController::class, 'liberar'])->name('contrato.liberar');
Route::get('filtro/contrato/{tipo}', [ContratoMarcoController::class, 'filtros'])->name('contrato.filtro');
Route::resource('/contrato', ContratoMarcoController::class);
Route::get('anexos_contrato/manexos/{id}', [AnexosContratoController::class, 'manexos'])->name('anexos_contrato.manexos');
Route::get('/fetch_anexoscm/anexos_contrato/', [AnexosContratoController::class, 'fetch_anexoscm'])->name('anexos_contrato.fetch_anexoscm');
Route::get('/descargar_archivo/anexos_contrato/{archivo}', [AnexosContratoController::class, 'descargar_archivo'])->name('anexos_contrato.descargar_archivo');
Route::resource('/anexos_contrato', AnexosContratoController::class);
Route::resource('/expedientes_contrato', ExpedientesContratoController::class);
Route::match(['put', 'patch'], 'liberar/expedientes_contrato/{id}', [ExpedientesContratoController::class, 'liberar'])->name('expedientes_contrato.liberar');
Route::get('filtro/expedientes_contrato/{tipo}', [ExpedientesContratoController::class, 'filtros'])->name('expedientes_contrato.filtro');
Route::resource('/cat_producto', CatProductoController::class);
Route::get('/data/cat_producto', [CatProductoController::class, 'data'])->name('cat_producto.data');
Route::resource('/grupo_revisor', GrupoRevisorController::class);
Route::resource('/cm_urg', ContratoMarcoUrgController::class);
Route::get('/cm_urg/abrir_au/{id}', [ContratoMarcoUrgController::class, 'abrirAgregarUrg'])->name('cm_urg.abrir_au');
Route::get('/fetch_cmu/cm_urg/{id_cm}', [ContratoMarcoUrgController::class, 'fetchCMU'])->name('cm_urg.fetch_cmu');
Route::get('/ver_archivo/cm_urg/{archivo}', [ContratoMarcoUrgController::class, 'verArchivo'])->name('cm_urg.ver_archivo');
Route::get('/habilitar_participante/cm_urg/{opcion}/{id}', [ContratoMarcoUrgController::class, 'habilitarParticipante'])->name('cm_urg.habilitar_participante');
Route::resource('habilitar_proveedores', HabilitarProveedoreController::class);
Route::get('/data/habilitar_proveedores', [HabilitarProveedoreController::class, 'data'])->name('habilitar_proveedores.data');
Route::resource('habilitar_productos', HabilitarProductoController::class);
Route::get('/data/habilitar_productos', [HabilitarProductoController::class, 'data'])->name('habilitar_productos.data');
Route::get('/catalogo/habilitar_productos/{id}', [HabilitarProductoController::class, 'catalogo'])->name('habilitar_productos.catalogo');
Route::resource('submenu', SubmenuController::class);
Route::get('/producto/habilitar_productos/{id}', [HabilitarProductoController::class, 'producto'])->name('habilitar_productos.producto');
Route::get('/habilitar_productos/show/producto/{id}', [HabilitarProductoController::class, 'showProducto'])->name('habilitar_productos.show_producto');
Route::get('habilitar_productos/modal/economica/{producto}', [HabilitarProductoController::class, 'modalEconomica'])->name('habilitar_productos.modal_economica');
Route::get('habilitar_productos/modal/administrativa/{producto}', [HabilitarProductoController::class, 'modalAdministrativa'])->name('habilitar_productos.modal_administrativa');
Route::get('habilitar_productos/modal/publicar/{producto}', [HabilitarProductoController::class, 'modalPublicar'])->name('habilitar_productos.modal_publicar');
Route::get('habilitar_productos/modal/tecnica/{producto}', [HabilitarProductoController::class, 'modalShowTecnica'])->name('habilitar_productos.modal_show_tecnica');
Route::post('habilitar_productos/publicar/producto', [HabilitarProductoController::class, 'publicarProducto'])->name('habilitar_productos.publicar_producto');
Route::resource('validacion_administrativas', ValidacionAdministrativaController::class);
Route::resource('usuarios', UserController::class);
Route::get('/data/usuarios', [UserController::class, 'data'])->name('usuarios.data');

//orden compra admin
Route::get('orden_compra_admin/', [OrdenCompraAdminController::class, 'index'])->name('orden_compra_admin.index');
Route::get('orden_compra_admin/confirmacion', [OrdenCompraAdminController::class, 'confirmacion'])->name('orden_compra_admin.confirmacion');
Route::get('orden_compra_admin/confirmacion/rechazadas_modal', [OrdenCompraAdminController::class, 'rechazadasModal'])->name('orden_compra_admin.rechazadas_modal');
Route::get('orden_compra_admin/contrato', [OrdenCompraAdminController::class, 'contrato'])->name('orden_compra_admin.contrato');
Route::get('orden_compra_admin/envio', [OrdenCompraAdminController::class, 'envio'])->name('orden_compra_admin.envio');
Route::get('orden_compra_admin/sustitucion', [OrdenCompraAdminController::class, 'sustitucion'])->name('orden_compra_admin.sustitucion');
Route::get('orden_compra_admin/sustitucion/datos_facturacion', [OrdenCompraAdminController::class, 'datosFacturacion'])->name('orden_compra_admin.datos_facturacion');
Route::get('orden_compra_admin/facturacion', [OrdenCompraAdminController::class, 'facturacion'])->name('orden_compra_admin.facturacion');
Route::get('orden_compra_admin/pago', [OrdenCompraAdminController::class, 'pago'])->name('orden_compra_admin.pago');
Route::get('orden_compra_admin/evaluacion', [OrdenCompraAdminController::class, 'evaluacion'])->name('orden_compra_admin.evaluacion');
Route::get('orden_compra_admin/data', [OrdenCompraAdminController::class, 'data'])->name('orden_compra_admin.data');
Route::get('/orden_compra_admin/export_orden_confirmada', [OrdenCompraAdminController::class, 'exportOrdenConfirmada'])->name('orden_compra_admin.export_orden_confirmada');
Route::get('orden_compra_admin/solicitud/{id}', [OrdenCompraAdminController::class, 'showSolicitud'])->name('orden_compra_admin.show_solicitud');
Route::get('orden_compra_admin/data_show/{id}', [OrdenCompraAdminController::class, 'dataShow'])->name('orden_compra_admin.data_show');
Route::get('orden_compra_admin/data_productos/{id}', [OrdenCompraAdminController::class, 'dataProductos'])->name('orden_compra_admin.data_productos');
Route::get('orden_compra_admin/seguimiento/{id}', [OrdenCompraAdminController::class, 'seguimiento'])->name('orden_compra_admin.seguimiento');
Route::get('orden_compra_admin/acuse_producto_confirmada/{proveedor}', [OrdenCompraAdminController::class, 'acuseProductosConfirmados'])->name('orden_compra_admin.acuse_producto_confirmada');
Route::get('orden_compra_admin/{id}', [OrdenCompraAdminController::class, 'show'])->name('orden_compra_admin.show');

//reportes admin
Route::get('reportes/', [ReporteAdminController::class, 'index'])->name('reporte_admin.index');
Route::get('reportes/data', [ReporteAdminController::class, 'data'])->name('reporte_admin.data');
Route::post('reportes/save', [ReporteAdminController::class, 'save'])->name('reporte_admin.save');
Route::get('reportes/show/{id}', [ReporteAdminController::class, 'showReporte'])->name('reporte_admin.show');
Route::post('reportes/descarga/', [ReporteAdminController::class, 'descargaReporte'])->name('reporte_admin.descarga');

//productos admin 
Route::get('admin/opiniones/producto/{producto}',[AdminController::class,'opinionProducto'])->name('producto_admin.opinion_producto');
Route::get('admin/opiniones/proveedor/{proveedor}',[AdminController::class,'opinionProveedor'])->name('producto_admin.opinion_proveedor');
Route::get('admin/cm_modal/{filtro}',[AdminController::class,'cmModal'])->name('producto_admin.cm_modal');
Route::get('admin/productos',[AdminController::class,'productosIndex'])->name('producto_admin.index');
Route::get('admin/producto/filtro/{filtro}',[AdminController::class,'productosAdmin'])->name('producto_admin.productos');
Route::get('admin/producto/{id}',[AdminController::class,'productoShowAdmin'])->name('producto_admin.show');


//urg

Route::get('/tienda_urg/ver_tienda/{requisicion?}', [TiendaUrgController::class, 'verTienda'])->name('tienda_urg.ver_tienda');
Route::get('/tienda_urg/ver_tienda_cabms/{cabms}', [TiendaUrgController::class, 'verTiendaCabms'])->name('tienda_urg.ver_tienda_cabms');
Route::get('/tienda_urg/cargar_contratosm', [TiendaUrgController::class, 'buscarContratosM'])->name('tienda_urg.cargar_contratosm');
Route::get('/tienda_urg/cargar_productos/{filtro?}', [TiendaUrgController::class, 'cargarProductos'])->name('tienda_urg.cargar_productos');
Route::get('/tienda_urg/cargar_filtro_tamanios_tiempo/{filtro?}', [TiendaUrgController::class, 'cargarFiltroTamaniosTiempo'])->name('tienda_urg.cargar_filtro_tamanios_tiempo');
Route::get('/tienda_urg/cargar_filtro_cabms/{filtro?}', [TiendaUrgController::class, 'cargarFiltroTiempoEntrega'])->name('tienda_urg.cargar_filtro_cabms');
Route::get('/tienda_urg/abrir_mcabms/{filtro}', [TiendaUrgController::class, 'abrirModalCabms'])->name('tienda_urg.abrir_mcabms');
Route::get('/tienda_urg/ver_doc/{archivo}/{quien?}', [TiendaUrgController::class, 'verDoc'])->name('tienda_urg.ver_doc');
Route::get('/tienda_urg/cargar_carrusel/', [TiendaUrgController::class, 'cargarElementosCarrusel'])->name('tienda_urg.cargar_carrusel');
Route::get('/tienda_urg/modal', [TiendaUrgController::class, 'modalMensaje'])->name('tienda_urg.modal_mensaje');
Route::post('/tienda_urg/modal/store', [TiendaUrgController::class, 'storeMensaje'])->name('tienda_urg.store_mensaje');
Route::get('/tienda_urg/opiniones/producto/{producto}',[TiendaUrgController::class,'opinionProducto'])->name('tienda_urg.opinion_producto');
Route::get('/tienda_urg/opiniones/producto/{producto}/{estrellas}',[TiendaUrgController::class,'opnionProductoFiltro'])->name('tienda_urg.opinion_producto_filtro');
Route::get('/tienda_urg/opiniones/proveedor/{proveedor}',[TiendaUrgController::class,'opinionProveedor'])->name('tienda_urg.opinion_proveedor');
Route::get('/tienda_urg/opiniones/proveedor/{proveedor}/{estrellas}',[TiendaUrgController::class,'opinionProveedorFiltro'])->name('tienda_urg.opinion_proveedor_filtro');
Route::resource('/tienda_urg', TiendaUrgController::class);

Route::get('/pro_pre/get_preguntas_respuestas/{id}', [ProductosPreguntasRespuestasController::class, 'getPreguntasRespuestas'])->name('pro_pre.get_preguntas_respuestas');
Route::get('/pro_pre/modal_enviar_preguntas', [ProductosPreguntasRespuestasController::class, 'abrirModalEnviarPreguntas'])->name('pro_pre.modal_enviar_preguntas');
Route::get('/pro_pre/cpr/{id}/{limitado?}', [ProductosPreguntasRespuestasController::class, 'cargarPreguntasRespuestas'])->name('pro_pre.cpr');
Route::resource('/pro_pre', ProductosPreguntasRespuestasController::class);

Route::resource('/pfu', ProductosFavoritosUrgController::class);

Route::get('/requisiciones/modal_seleccionar_requisicion/{cabms}', [RequisicioneController::class, 'modalSeleccionarRequisicion'])->name('requisiciones.modal_seleccionar_requisicion');
Route::get('requisiciones/obtener_requisicion', [RequisicioneController::class, 'obtenerRequisicion'])->name('requisiciones.obtener_requisicion');
Route::resource('/requisiciones', RequisicioneController::class);
Route::get('data/requisiciones/', [RequisicioneController::class, 'data'])->name('requisiciones.data');
Route::post('export/requisiciones/', [RequisicioneController::class, 'export'])->name('requisiciones.export');
Route::resource('/bien_servicio', BienServicioController::class);
Route::get('data/bien_servicio/{id}', [BienServicioController::class, 'data'])->name('bien_servicio.data');

Route::resource('/solucitud_compra', SolicitudCompraController::class);
Route::post('export/solucitud_compra/', [SolicitudCompraController::class, 'export'])->name('solicitud_compra.export');
Route::get('/orden_compra/export_orden_confirmada', [OrdenCompraController::class, 'exportOrdenConfirmada'])->name('orden_compra.export_orden_confirmada');
Route::resource('/orden_compra', OrdenCompraController::class);
Route::get('data/orden_compra', [OrdenCompraController::class, 'data'])->name('orden_compra.data');
Route::get('data_show/orden_compra/{id}', [OrdenCompraController::class, 'dataShow'])->name('orden_compra.data_show');
Route::get('data_productos/orden_compra/{id}', [OrdenCompraController::class, 'dataProductos'])->name('orden_compra.data_productos');
Route::get('orden_compra/acuse_producto_confirmada/{proveedor}', [OrdenCompraController::class, 'acuseProductosConfirmados'])->name('orden_compra.acuse_producto_confirmada');

Route::get('orden_compra_urg/seguimiento/confirmacion', [OrdenCompraUrgController::class, 'confirmacion'])->name('orden_compra_urg.confirmacion');
Route::get('orden_compra_urg/seguimiento/rechazadas_modal', [OrdenCompraUrgController::class, 'rechazadasModal'])->name('orden_compra_urg.rechazadas_modal');
Route::get('orden_compra_urg/seguimiento/cancelar/{etapa}', [OrdenCompraUrgController::class, 'cancelarModal'])->name('orden_compra_urg.cancelar_modal');
Route::post('orden_compra_urg/seguimiento/cancelar_save', [OrdenCompraUrgController::class, 'cancelarSave'])->name('orden_compra_urg.cancelar_save');
Route::get('orden_compra_urg/seguimiento/reporte/{etapa}', [OrdenCompraUrgController::class, 'reporteModal'])->name('orden_compra_urg.reporte_modal');
Route::post('orden_compra_urg/seguimiento/reporte_save', [OrdenCompraUrgController::class, 'reporteSave'])->name('orden_compra_urg.reporte_save');
Route::get('orden_compra_urg/seguimiento/incidencia/{etapa}', [OrdenCompraUrgController::class, 'incidenciaModal'])->name('orden_compra_urg.incidencia_modal');
Route::post('orden_compra_urg/seguimiento/incidencia_save', [OrdenCompraUrgController::class, 'incidenciaSave'])->name('orden_compra_urg.incidencia_save');
Route::get('orden_compra_urg/seguimiento/prorroga', [OrdenCompraUrgController::class, 'prorrogaModal'])->name('orden_compra_urg.prorroga_modal');
Route::post('orden_compra_urg/seguimiento/prorroga_update', [OrdenCompraUrgController::class, 'prorrogaUpdate'])->name('orden_compra_urg.prorroga_update');
Route::get('orden_compra_urg/seguimiento/subir_acuse', [OrdenCompraUrgController::class, 'acuseModal'])->name('orden_compra_urg.acuse_modal');
Route::post('orden_compra_urg/seguimiento/subir_acuse_update', [OrdenCompraUrgController::class, 'acuseUpdate'])->name('orden_compra_urg.acuse_update');
Route::get('orden_compra_urg/seguimiento/alta_contrato_1', [OrdenCompraUrgController::class, 'altaContrato'])->name('orden_compra_urg.alta_contrato_1');
Route::post('orden_compra_urg/seguimiento/alta_contrato_2', [OrdenCompraUrgController::class, 'altaContrato2'])->name('orden_compra_urg.alta_contrato_2');
Route::get('orden_compra_urg/seguimiento/alta_contrato_3', [OrdenCompraUrgController::class, 'altaContrato3'])->name('orden_compra_urg.alta_contrato_3');
Route::get('orden_compra_urg/seguimiento/alta_contrato_4', [OrdenCompraUrgController::class, 'altaContrato4'])->name('orden_compra_urg.alta_contrato_4');
Route::get('orden_compra_urg/seguimiento/alta_contrato_5', [OrdenCompraUrgController::class, 'altaContrato5'])->name('orden_compra_urg.alta_contrato_5');
Route::post('orden_compra_urg/seguimiento/revisar_contrato', [OrdenCompraUrgController::class, 'revisarContrato'])->name('orden_compra_urg.revisar_contrato');
Route::get('orden_compra_urg/seguimiento/firmar_contrato', [OrdenCompraUrgController::class, 'firmarContrato'])->name('orden_compra_urg.firmar_contrato');
Route::get('orden_compra_urg/seguimiento/firmante/edit/{id}', [OrdenCompraUrgController::class, 'firmanteModalEdit'])->name('orden_compra_urg.firmante_modal_edit');
Route::get('orden_compra_urg/seguimiento/firmante/{id}', [OrdenCompraUrgController::class, 'firmanteModal'])->name('orden_compra_urg.firmante_modal');
Route::get('orden_compra_urg/seguimiento/almacen', [OrdenCompraUrgController::class, 'almacenModal'])->name('orden_compra_urg.almacen_modal');
Route::get('orden_compra_urg/seguimiento/almacen/edit', [OrdenCompraUrgController::class, 'almacenModalEdit'])->name('orden_compra_urg.almacen_modal_edit');
Route::get('orden_compra_urg/seguimiento/almacen/responsable/{ccg}', [OrdenCompraUrgController::class, 'responsableAlmacen'])->name('orden_compra_urg.almacen_responsable');
Route::post('orden_compra_urg/seguimiento/almacenSave', [OrdenCompraUrgController::class, 'almacenSave'])->name('orden_compra_urg.almacen_save');
Route::get('orden_compra_urg/seguimiento/facturacion_modal', [OrdenCompraUrgController::class, 'facturacionModal'])->name('orden_compra_urg.facturacion_modal');
Route::put('orden_compra_urg/seguimiento/facturacion/edit', [OrdenCompraUrgController::class, 'facturacionEdit'])->name('orden_compra_urg.facturacion_edit');
Route::get('orden_compra_urg/seguimiento/datos_facturacion', [OrdenCompraUrgController::class, 'datosFacturacion'])->name('orden_compra_urg.datos_facturacion');
Route::get('orden_compra_urg/seguimiento/productos_sustituir', [OrdenCompraUrgController::class, 'productosSustituirModal'])->name('orden_compra_urg.productos_sustituir_modal');
Route::get('orden_compra_urg/seguimiento/usuario/{rfc}', [OrdenCompraUrgController::class, 'findUsuario'])->name('orden_compra_urg.find_usuario');
Route::post('orden_compra_urg/seguimiento/firmanteSave', [OrdenCompraUrgController::class, 'firmanteSave'])->name('orden_compra_urg.firmante_save');
Route::put('orden_compra_urg/seguimiento/firmanteEdit', [OrdenCompraUrgController::class, 'firmanteEdit'])->name('orden_compra_urg.firmante_edit');
Route::post('orden_compra_urg/seguimiento/efirma', [OrdenCompraUrgController::class, 'efirmaSave'])->name('orden_compra_urg.efirma_save');
Route::get('orden_compra_urg/seguimiento/acuse_confirmada', [OrdenCompraUrgController::class, 'acuseConfirmada'])->name('orden_compra_urg.acuse_confirmada');
Route::get('orden_compra_urg/seguimiento/envio', [OrdenCompraUrgController::class, 'envio'])->name('orden_compra_urg.envio');
Route::post('orden_compra_urg/seguimiento/aceptar_envio', [OrdenCompraUrgController::class, 'aceptarEnvio'])->name('orden_compra_urg.aceptar_envio');
Route::get('orden_compra_urg/seguimiento/sustitucion', [OrdenCompraUrgController::class, 'sustitucion'])->name('orden_compra_urg.sustitucion');
Route::post('orden_compra_urg/seguimiento/acuse_sustitucion', [OrdenCompraUrgController::class, 'acuseSustitucion'])->name('orden_compra_urg.acuse_sustitucion');
Route::post('orden_compra_urg/seguimiento/aceptar_sustitucion', [OrdenCompraUrgController::class, 'aceptarSustitucion'])->name('orden_compra_urg.aceptar_sustitucion');
Route::get('orden_compra_urg/seguimiento/facturacion', [OrdenCompraUrgController::class, 'facturacion'])->name('orden_compra_urg.facturacion');
Route::get('orden_compra_urg/seguimiento/cambio_facturacion_modal', [OrdenCompraUrgController::class, 'solicitarCambiosModal'])->name('orden_compra_urg.solicitar_cambios_modal');
Route::post('orden_compra_urg/seguimiento/solicitar_cambio', [OrdenCompraUrgController::class, 'solicitarCambioSave'])->name('orden_compra_urg.solicitar_cambios_save');
Route::post('orden_compra_urg/seguimiento/aceptar_factura', [OrdenCompraUrgController::class, 'aceptarFactura'])->name('orden_compra_urg.aceptar_factura');
Route::get('orden_compra_urg/seguimiento/aceptar_sap_modal', [OrdenCompraUrgController::class, 'aceptarSapModal'])->name('orden_compra_urg.aceptar_sap_modal');
Route::post('orden_compra_urg/seguimiento/factura_sap', [OrdenCompraUrgController::class, 'facturaEnSap'])->name('orden_compra_urg.factura_en_sap');
Route::get('orden_compra_urg/seguimiento/pago', [OrdenCompraUrgController::class, 'pago'])->name('orden_compra_urg.pago');
Route::get('orden_compra_urg/seguimiento/comprobante_clc_modal', [OrdenCompraUrgController::class, 'comprobanteClcModal'])->name('orden_compra_urg.comprobante_clc_modal');
Route::post('orden_compra_urg/seguimiento/comprobante_clc_save', [OrdenCompraUrgController::class, 'comprobanteClcSave'])->name('orden_compra_urg.comprobante_clc_save');
Route::get('orden_compra_urg/seguimiento/retraso_modal', [OrdenCompraUrgController::class, 'retrasoModal'])->name('orden_compra_urg.retraso_modal');
Route::post('orden_compra_urg/seguimiento/retraso_save', [OrdenCompraUrgController::class, 'retrasoSave'])->name('orden_compra_urg.retraso_save');
Route::get('orden_compra_urg/seguimiento/evaluacion', [OrdenCompraUrgController::class, 'evaluacion'])->name('orden_compra_urg.evaluacion');
Route::post('orden_compra_urg/seguimiento/evaluacion_save', [OrdenCompraUrgController::class, 'evaluacionSave'])->name('orden_compra_urg.evaluacion_save');
Route::get('orden_compra_urg/seguimiento/evaluacion/{id}', [OrdenCompraUrgController::class, 'evaluacionEdit'])->name('orden_compra_urg.evaluacion_edit');
Route::get('orden_compra_urg/seguimiento/{id}', [OrdenCompraUrgController::class, 'index'])->name('orden_compra_urg.index');

//mensajes URG
Route::get('/mensajes_urg/', [UrgGeneralController::class, 'mensajesUrg'])->name('mensajes_urg.mensajes');
Route::get('/mensajes_urg/data/{id}', [UrgGeneralController::class, 'dataMensajes'])->name('mensajes_urg.mensajes_data');
Route::post('/mensajes_urg/destacar', [UrgGeneralController::class, 'destacarMensaje'])->name('mensajes_urg.mensaje_destacar');
Route::post('/mensajes_urg/archivar', [UrgGeneralController::class, 'archivarMensaje'])->name('mensajes_urg.mensaje_archivar');
Route::post('/mensajes_urg/eliminar', [UrgGeneralController::class, 'eliminarMensaje'])->name('mensajes_urg.mensaje_eliminar');
Route::post('/mensajes_urg/leido', [UrgGeneralController::class, 'leido'])->name('mensajes_urg.mensaje_leido');
Route::get('/mensajes_urg/responder_modal/{id}', [UrgGeneralController::class, 'responderModal'])->name('mensajes_urg.mensaje_responder_modal');
Route::post('mensajes_urg/responder_save', [UrgGeneralController::class, 'responderSave'])->name('mensajes_urg.mensaje_responder_save');


//vista contratos marco urg
Route::get('contrato_urg/', [ContratosVistaController::class, 'indexUrg'])->name('contrato_urg.index_urg');
Route::get('contrato_urg/show/{contrato}', [ContratosVistaController::class, 'showUrg'])->name('contrato_urg.show_urg');

//incidencias Urg
Route::get('incidencias_urg/', [IncidenciaUrgController::class, 'index'])->name('incidencia_urg.index');
Route::get('incidencias_urg/data', [IncidenciaUrgController::class, 'data'])->name('incidencia_urg.data_urg');
Route::get('incidencias_urg/data/filtro/{filtro}', [IncidenciaUrgController::class, 'dataUrgFiltro'])->name('incidencia_urg.data_urg_filtro');
Route::get('incidencias_urg/conformidad_modal', [IncidenciaUrgController::class, 'modalConformidad'])->name('incidencia_urg.modal_conformidad');
Route::post('incidencias_urg/save_conformidad', [IncidenciaUrgController::class, 'saveConformidad'])->name('incidencia_urg.conformidad_save');
Route::get('incidencias_urg/data_admin', [IncidenciaUrgController::class, 'dataAdmin'])->name('incidencia_urg.data_admin');
Route::get('incidencias_urg/data_admin/filtro/{filtro}', [IncidenciaUrgController::class, 'dataAdminFiltro'])->name('incidencia_urg.data_admin_filtro');

//reportes urg
Route::get('reportes_urg/', [ReporteUrgController::class, 'index'])->name('reporte_urg.index');
Route::get('reportes_urg/data', [ReporteUrgController::class, 'data'])->name('reporte_urg.data');
Route::post('reportes_urg/save', [ReporteUrgController::class, 'save'])->name('reporte_urg.save');
Route::get('reportes_urg/show/{id}', [ReporteUrgController::class, 'showReporte'])->name('reporte_urg.show');
Route::post('reportes_urg/descarga/', [ReporteUrgController::class, 'descargaReporte'])->name('reporte_urg.descarga');

//contrato pedido urg 
Route::get('contrato_oc_urg/',[ContratoOcUrgController::class, 'index'])->name('contrato_oc_urg.index');
Route::get('contrato_oc_urg/data',[ContratoOcUrgController::class, 'data'])->name('contrato_oc_urg.data');


//validador tecnico
Route::resource('/validador_tecnico', ValidadorTecnicoController::class);
Route::get('/data/validador_tecnico', [ValidadorTecnicoController::class, 'data'])->name('validador_tecnico.data');
Route::get('/show_producto/validador_tecnico/{producto_id}', [ValidadorTecnicoController::class, 'showProducto'])->name('validador_tecnico.show_producto');
Route::get('contrato_validador/', [ContratosVistaController::class, 'indexValidador'])->name('contrato_validador.index');
Route::get('contrato_validador/show/{contrato}', [ContratosVistaController::class, 'showValidador'])->name('contrato_validador.show');

//firmantes
Route::resource('/firmante', FirmantesController::class);
Route::get('/data/firmante', [FirmantesController::class, 'data'])->name('firmante.data');
Route::get('/modal/firmante', [FirmantesController::class, 'firmarModal'])->name('firmante.firmar_modal');


//servicios 
Route::get('capitulo/{capitulo}', [ServiceController::class, 'capitulos'])->name('service.capitulo');
Route::get('partida/{partida}', [ServiceController::class, 'partidas'])->name('service.partida');
Route::get('cabms/{partida}/{cabms}', [ServiceController::class, 'claveCabms'])->name('service.cabms');
Route::get('convocatorias/{convocatoria}', [ServiceController::class, 'convocatorias'])->name('service.convocatoria');
Route::get('almacen/{ccg}', [ServiceController::class, 'almacen'])->name('service.almacen');
Route::get('get_proveedor/{rfc}', [ServiceController::class, 'proveedor'])->name('service.proveedores');
Route::get('personal_acceso/{ccg}', [ServiceController::class, 'accesoUnico'])->name('service.acceso_unico');
Route::get('personal/{rfc}', [ServiceController::class, 'personalAcceso'])->name('service.personal_acceso');
Route::get('resposables_almacen/{ccg}', [ServiceController::class, 'responsableAlmacen'])->name('service.responsables_almacen');
Route::get('datos/proveedor/contrato/{rfc}', [ServiceController::class, 'datosProveedorContrato'])->name('service.datos_proveedor_contrato');

Route::get('/login_url', [PruebaController::class, 'login_url']);
Route::get('logout', [PruebaController::class, 'logout'])->name('users.logout');


// Zona carrito compra
Route::get('cc/cantidad_productos_carrito', [CarritoCompraController::class, 'cantidadProductosCarrito'])->name('carrito_compra.cantidad_productos_carrito');
Route::get('cc/mostrar_productos_carrito', [CarritoCompraController::class, 'mostrarProductosCarritoConIva'])->name('carrito_compra.mostrar_productos_carrito');
Route::POST('carrito_compra/confirmar_orden_compra/', [CarritoCompraController::class, 'viewConfirmarOrdenCompra'])->name('carrito_compra.confirmar_orden_compra');
Route::resource('/carrito_compra', CarritoCompraController::class);

//proveedor
Route::prefix('proveedor')->group(function () {
    Route::middleware(['guest:proveedor'])->group(function () {
        Route::get('/login', [ProveedorController::class, 'acceso'])->name('proveedor.login');
        Route::post('/checar_perfil', [ProveedorController::class, 'checarPerfil'])->name('proveedor.checar_perfil');
    });

    Route::middleware(['auth:proveedor'])->group(function () {
        Route::get('/logout', [ProveedorController::class, 'logout'])->name('proveedor.logout');
    });

    Route::middleware(['auth:proveedor', 'perfilActivo'])->group(function () {
        Route::get('/abrir_me', [ProveedorController::class, 'abrirME'])->name('proveedor.abrir_me');
        Route::get('/perfil_exitoso', [ProveedorController::class, 'abrirPerfilExitoso'])->name('proveedor.perfil_exitoso');
    });

    Route::middleware(['auth:proveedor', 'matrizLlena', 'verificarConstancia', 'perfilActivo'])->group(function () {
        Route::get('/aip', [ProveedorController::class, 'abrirInicioProveedor'])->name('proveedor.aip');
        Route::get('/modal_enviar_mensaje', [ProveedorController::class, 'modalEnviarMensaje'])->name('proveedor.modal_enviar_mensaje');
        Route::post('/guardar_mensaje', [ProveedorController::class, 'guardarMensaje'])->name('proveedor.guardar_mensaje');
    });

    Route::middleware(['auth:proveedor', 'constanciaVigente', 'perfilActivo'])->group(function () {
        Route::get('/vigente', [ProveedorController::class, 'matrizVigente'])->name('proveedor.vigente');
        Route::post('/guardar_me_vigente', [ProveedorController::class, 'guardarMatrizEscalamiento'])->name('proveedor.guardar_me_vigente');
    });

    Route::middleware(['auth:proveedor', 'constanciaVigenteEditar', 'perfilActivo'])->group(function () {
        Route::get('/vigente_editar', [ProveedorController::class, 'matrizVigenteEditar'])->name('proveedor.vigente_editar');
        Route::post('/actualizar_me', [ProveedorController::class, 'guardarMatrizEscalamiento'])->name('proveedor.actualizar_me');
        Route::get('/redirigir_actualizado', [ProveedorController::class, 'redirigirGuardado'])->name('proveedor.redirigir_actualizado');
    });

    Route::middleware(['auth:proveedor', 'constanciaVencida', 'perfilActivo'])->group(function () {
        Route::get('/vencida', [ProveedorController::class, 'matrizVencida'])->name('proveedor.vencida');
        Route::get('/vencida_salir', [ProveedorController::class, 'salirMatrizVencida'])->name('proveedor.vencida_salir');
    });

    Route::middleware(['auth:proveedor', 'perfilCompleto', 'perfilActivo'])->group(function () {
        Route::get('/perfil_completar/', [ProveedorController::class, 'abrirPerfilCompletar'])->name('proveedor.perfil_completar');
        Route::post('/guardar_me', [ProveedorController::class, 'guardarMatrizEscalamiento'])->name('proveedor.guardar_me');
        Route::get('/redirigir_guardado', [ProveedorController::class, 'redirigirGuardado'])->name('proveedor.redirigir_guardado');
    });

    Route::middleware(['auth:proveedor', 'perfilConfirmar', 'perfilActivo'])->group(function () {
        Route::get('/perfil_confirmar', [ProveedorController::class, 'abrirPerfilConfirmar'])->name('proveedor.perfil_confirmar');
        Route::get('/reenviar_cc', [ProveedorController::class, 'reenviarCorreoCodigo'])->name('proveedor.reenviar_cc');
        Route::post('/comprobar_codigo/', [ProveedorController::class, 'comprobarCodigo'])->name('proveedor.comprobar_codigo');
    });
});


Route::get('/proveedor_fp/abrir_pi/{id}', [ProveedorFichaProductoController::class, 'abrirProductoInicio'])->name('proveedor_fp.abrir_pi');
Route::get('/proveedor_fp/m_color/{id}', [ProveedorFichaProductoController::class, 'abrirModalColor'])->name('proveedor_fp.m_color');
Route::get('/proveedor_fp/m_dimensiones/{id}', [ProveedorFichaProductoController::class, 'abrirModalDimensiones'])->name('proveedor_fp.m_dimensiones');
Route::get('/proveedor_fp/ver_doc/{archivo}/{quien?}', [ProveedorFichaProductoController::class, 'verDoc'])->name('proveedor_fp.ver_doc');
Route::get('/proveedor_fp/abrir_index/{producto_id}/{filtro?}', [ProveedorFichaProductoController::class, 'abrirIndex'])->name('proveedor_fp.abrir_index');
Route::POST('/proveedor_fp/duplicar', [ProveedorFichaProductoController::class, 'duplicar'])->name('proveedor_fp.duplicar');
Route::get('/fetchpfp/proveedor_fp', [ProveedorFichaProductoController::class, 'fetchPFP'])->name('proveedor_fp.fetchpfp');
Route::resource('/proveedor_fp', ProveedorFichaProductoController::class);
Route::get('/proveedor_fp/validacion_economica/{id}', [ProveedorFichaProductoController::class, 'validacionEconomica'])->name('proveedor_fp.validacion_economica');
Route::get('/proveedor_fp/modal_val_admin/{id}', [ProveedorFichaProductoController::class, 'modalValAdmin'])->name('proveedor_fp.modal_val_admin');
Route::get('/proveedor_fp/modal_val_tec/{id}', [ProveedorFichaProductoController::class, 'modalValTec'])->name('proveedor_fp.modal_val_tec');

Route::get('contrato_proveedor/', [ContratosVistaController::class, 'indexProveedor'])->name('contrato_proveedor.index_proveedor')->middleware(['auth:proveedor', 'matrizLlena', 'verificarConstancia' , 'perfilActivo']);
Route::get('contrato_proveedor/show/{contrato}', [ContratosVistaController::class, 'showProveedor'])->name('contrato_proveedor.show_proveedor')->middleware(['auth:proveedor', 'matrizLlena', 'verificarConstancia' , 'perfilActivo']);

//Orden compra proveedores
Route::get('/orden_compra_proveedores/acuse_confirmada', [OrdenCompraProveedorController::class, 'acuseConfirmada'])->name('orden_compra_proveedores.acuse_confirmada');
Route::get('/orden_compra_proveedores/export_orden_confirmada', [OrdenCompraProveedorController::class, 'exportOrdenConfirmada'])->name('orden_compra_proveedores.export_orden_confirmada');

Route::get('orden_compra_proveedores/contrato/index', [OrdenCompraProveedorController::class, 'indexContrato'])->name('orden_compra_proveedores.contrato.index');
Route::get('fetch_contratos/orden_compra_proveedores', [OrdenCompraProveedorController::class, 'fetchContratos'])->name('orden_compra_proveedores.fetch_contratos');

Route::post('orden_compra_proveedores/contrato/efirma', [OrdenCompraProveedorController::class, 'efirmaSave'])->name('orden_compra_proveedores.efirma_save');
Route::post('/orden_compra_proveedores/guardar_confirmacion', [OrdenCompraProveedorController::class, 'guardarConfirmacion'])->name('orden_compra_proveedores.guardar_confirmacion');
Route::post('/orden_compra_proveedores/rechazar_orden', [OrdenCompraProveedorController::class, 'rechazarOrdenCompra'])->name('orden_compra_proveedores.rechazar_orden');
Route::get('/orden_compra_proveedores/modal/{quien}', [OrdenCompraProveedorController::class, 'abrirModal'])->name('orden_compra_proveedores.modal');
Route::get('/orden_compra_proveedores/abrir_pagina/{seguimiento}/{quien?}', [OrdenCompraProveedorController::class, 'abrirPagina'])->name('orden_compra_proveedores.abrir_pagina');
Route::get('/orden_compra_proveedores/seguimiento/{id}', [OrdenCompraProveedorController::class, 'seguimiento'])->name('orden_compra_proveedores.seguimiento');
Route::get('fetch_productos_poc/orden_compra_proveedores', [OrdenCompraProveedorController::class, 'fetchProductosPorOrdenCompra'])->name('orden_compra_proveedores.fetch_productos_poc');
Route::get('fetch_ocp/orden_compra_proveedores', [OrdenCompraProveedorController::class, 'fetchOrdenCompraProveedor'])->name('orden_compra_proveedores.fetch_ocp');
Route::post('/orden_compra_proveedores/guardar_mensaje', [OrdenCompraProveedorController::class, 'guardarMensaje'])->name('orden_compra_proveedores.guardar_mensaje');
Route::resource('/orden_compra_proveedores', OrdenCompraProveedorController::class);

Route::get('/orden_compra_envio/descargar_nota_remision/{archivo}', [OrdenCompraEnvioController::class, 'descargarNotaRemision'])->name('orden_compra_envio.descargar_nota_remision');
Route::resource('orden_compra_envio', OrdenCompraEnvioController::class);

Route::post('/orden_compra_prorroga/firmar_prorroga', [OrdenCompraProrrogaController::class, 'firmarProrroga'])->name('orden_compra_prorroga.firmar_prorroga');
Route::get('/orden_compra_prorroga/descargar_acuse/{archivo}', [OrdenCompraProrrogaController::class, 'descargarAcuse'])->name('orden_compra_prorroga.descargar_acuse');
Route::get('/orden_compra_prorroga/descargar_solicitud/{archivo}', [OrdenCompraProrrogaController::class, 'descargarSolicitud'])->name('orden_compra_prorroga.descargar_solicitud');
Route::resource('orden_compra_prorroga', OrdenCompraProrrogaController::class);

Route::get('/orden_compra_sustitucion/descargar_nota_remision/{archivo}/{tipo?}', [OrdenCompraSustitucionController::class, 'descargarNotaRemision'])->name('orden_compra_sustitucion.descargar_nota_remision');
Route::post('/orden_compra_sustitucion/confirmar_envio_sustitucion', [OrdenCompraSustitucionController::class, 'confirmarEnvioSustitucion'])->name('orden_compra_sustitucion.confirmar_envio_sustitucion');
Route::resource('orden_compra_sustitucion', OrdenCompraSustitucionController::class);

Route::get('/orden_compra_factura/descargar_archivo/{archivo}/{tipo}', [OrdenCompraFacturaController::class, 'descargarArchivo'])->name('orden_compra_factura.descargar_archivo');
Route::resource('orden_compra_factura', OrdenCompraFacturaController::class);

Route::get('/orden_compra_pago/descargar_archivo/{archivo}', [OrdenCompraPagoController::class, 'descargarArchivo'])->name('orden_compra_pago.descargar_archivo');
Route::post('/orden_compra_pago/incidencia_guardar', [OrdenCompraPagoController::class, 'incidenciaGuardar'])->name('orden_compra_pago.incidencia_guardar');
Route::post('/orden_compra_pago/reporte_guardar', [OrdenCompraPagoController::class, 'reporteGuardar'])->name('orden_compra_pago.reporte_guardar');
Route::post('/orden_compra_pago/confirmar_pago', [OrdenCompraPagoController::class, 'confirmarPago'])->name('orden_compra_pago.confirmar_pago');
Route::resource('orden_compra_pago', OrdenCompraPagoController::class);

Route::resource('proveedor_comentario', ProveedorComentarioController::class);

Route::get('/fetch_reportes_desgloce/reporte_proveedor', [ReporteProveedorController::class, 'fetchReportesDesgloce'])->name('reporte_proveedor.fetch_reportes_desgloce');
Route::get('/fetch_reportes/reporte_proveedor', [ReporteProveedorController::class, 'fetchReportes'])->name('reporte_proveedor.fetch_reportes');
Route::get('reporte_proveedor/export/', [ReporteProveedorController::class, 'export'])->name('reporte_proveedor.export');
Route::resource('reporte_proveedor', ReporteProveedorController::class);

Route::get('/fetch_incidencias_admin/incidencia_proveedor', [IncidenciaProveedorController::class, 'fetchIncidenciasAdmin'])->name('incidencia_proveedor.fetch_incidencias_admin');
Route::get('/fetch_incidencias/incidencia_proveedor', [IncidenciaProveedorController::class, 'fetchIncidencias'])->name('incidencia_proveedor.fetch_incidencias');
Route::resource('incidencia_proveedor', IncidenciaProveedorController::class);

Route::post('/borrar/mensaje_proveedor', [MensajeProveedorController::class, 'borrar'])->name('mensaje_proveedor.borrar');
Route::post('/archivar/mensaje_proveedor', [MensajeProveedorController::class, 'archivar'])->name('mensaje_proveedor.archivar');
Route::post('/destacar/mensaje_proveedor', [MensajeProveedorController::class, 'destacar'])->name('mensaje_proveedor.destacar');
Route::post('/destacado_unico/mensaje_proveedor', [MensajeProveedorController::class, 'destacadoUnico'])->name('mensaje_proveedor.destacado_unico');
Route::post('/leido/mensaje_proveedor', [MensajeProveedorController::class, 'leido'])->name('mensaje_proveedor.leido');
Route::get('/fetch_mensajes/mensaje_proveedor/{estatus}', [MensajeProveedorController::class, 'fetchMensajes'])->name('mensaje_proveedor.fetch_mensajes');
Route::resource('mensaje_proveedor', MensajeProveedorController::class);
