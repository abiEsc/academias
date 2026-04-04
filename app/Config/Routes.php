<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->addRedirect("/", "Inicio");

// Acciones de Autenticacion
$routes->get("/Inicio-De-Sesion", "Home::login");
$routes->post('/login', 'LoginController::inicio_sesion');
$routes->get("/logout", "LoginController::logout");

// Contenido Principal
$routes->get('/Inicio', 'Home::index');

// Personal 
$routes->get("/Gestion-Personal", "PersonalController::index");
$routes->post('/Gestion-Personal/Registro', 'PersonalController::registrar_personal');
$routes->post('/Gestion-Personal/Recuperar/Personal', 'PersonalController::recuperar_personal');
$routes->post('/Gestion-Personal/Editar', 'PersonalController::editar_personal');
$routes->post('/Gestion-Personal/Inactivar', 'PersonalController::inactivar_personal');
$routes->post('/Gestion-Personal/Eliminar', 'PersonalController::eliminar_personal');
$routes->post('/Gestion-Personal/Reactivar', 'PersonalController::reactivar_personal');
$routes->post('/Gestion-Personal/Detalle/Cursos', 'PersonalController::detalle_cursos');

// Cliente
$routes->get("/Gestion-Cliente", "ClienteController::index");
$routes->post('/Gestion-Cliente/Registro', 'ClienteController::registrar_cliente');
$routes->post('/Gestion-Cliente/Recuperar/Cliente', 'ClienteController::recuperar_cliente');
$routes->post('/Gestion-Cliente/Editar', 'ClienteController::editar_cliente');
$routes->post('/Gestion-Cliente/Inactivar', 'ClienteController::inactivar_cliente');
$routes->post('/Gestion-Cliente/Eliminar', 'ClienteController::eliminar_cliente');
$routes->post('/Gestion-Cliente/Reactivar', 'ClienteController::reactivar_cliente');
$routes->post('/Gestion-Cliente/Detalle', 'Home::detalle_usuario');
$routes->post('/Gestion-Cliente/Detalle/Inscripcion', 'Home::detalle_inscripcion');
$routes->post('/Gestion-Cliente/Actualizar/Saldo', 'ClienteController::actualizar_saldo');
$routes->post('/Gestion-Cliente/Detalle/Sesion', 'ClienteController::detalle_sesion');
$routes->post('/Gestion-Cliente/Registrar/Sesion', 'ClienteController::registrar_sesion');
// Inscripciones
$routes->post('/Gestion-Cliente/Inscripcion', 'ClienteController::registrar_inscripcion');


// Inventario
$routes->get("/Gestion-Inventario", "InventarioController::index");
$routes->post("/Gestion-Inventario/Registro/Producto", "InventarioController::registrar_producto");
$routes->post("/Gestion-Inventario/Recuperar/Producto", "InventarioController::recuperar_producto");
$routes->post("/Gestion-Inventario/Eliminar/Producto", "InventarioController::eliminar_producto");
$routes->post("/Gestion-Inventario/Reactivar/Producto", "InventarioController::reactivar_producto");
// Ventas
$routes->post("/Gestion-Inventario/Registro/Venta", "InventarioController::venta_producto");
// Pagos
$routes->get("/Gestion-Pagos", "PagosController::index");
// Reportes
$routes->get("/Reportes", "ReportesController::index");
$routes->post("/Reportes/Generar", "ReportesController::generar_reporte");

// Cursos
$routes->get("/Gestion-Cursos", "CursosController::index");
$routes->post("/Gestion-Cursos/Registro/Curso", "CursosController::registro_curso");
$routes->post("/Gestion-Cursos/Recuperar/Curso", "CursosController::recuperar_curso");
$routes->post("/Gestion-Cursos/Eliminar/Curso", "CursosController::eliminar_curso");
$routes->post("/Gestion-Cursos/Asociar/Instructor", "CursosController::asociar_instructor");

// Paquetes
$routes->post("/Gestion-Cursos/Registro/Paquete", "CursosController::registro_paquete");
$routes->post("/Gestion-Cursos/Recuperar/Paquete", "CursosController::recuperar_paquete");
$routes->post("/Gestion-Cursos/Eliminar/Paquete", "CursosController::eliminar_paquete");

// Promociones
$routes->post("/Gestion-Cursos/Registro/Promocion", "CursosController::registrar_promocion");
$routes->post("/Gestion-Cursos/Recuperar/Promocion", "CursosController::recuperar_promocion");
$routes->post("/Gestion-Cursos/Editar/Promocion", "CursosController::editar_promocion");

// Promociones
$routes->get("/Gestion-Promociones", "PromocionesController::index");

// Sucursales
$routes->get("/Gestion-Sucursales", "SucursalesController::index");
$routes->post("/Gestion-Sucursal/Recuperar/Sucursal", "SucursalesController::recuperar_sucursal");
$routes->post("/Gestion-Sucursal/Registrar/Sucursal", "SucursalesController::registrar_sucursal");


// General
$routes->post("/Guardar/Media", "Home::guardar_media");
$routes->post("/Remover/Media", "Home::remover_media");


// WebService
$routes->post('/API', 'RESTController::receiveRequest');


// Promociones
// $routes->post("/Registro/Promociones");

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
