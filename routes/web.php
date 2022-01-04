<?php

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

//auth
Route::get('auth/login', 'Seguridad\LoginController@index')->name('login');
Route::post('auth/login', 'Seguridad\LoginController@login')->name('login_post');
Route::get('auth/logout', 'Seguridad\LoginController@logout')->name('logout');

Route::get('/', 'Admin\InicioController@index');

//middleware "root" es para el Usuario-> ADMINISTRADOR PRINCIAPAL, ID=1
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'root']], function () {
    /* Rutas de ACCESO */
    Route::get('acceso', 'AccesoController@index')->name('acceso');
    Route::post('acceso', 'AccesoController@store')->name('store_acceso');
    /* Rutas de GRUPOMENU */
    Route::post('grupomenu/buscar', 'GrupoMenuController@buscar')->name('grupomenu.buscar');
    Route::get('grupomenu/eliminar/{id}/{listarluego}', 'GrupoMenuController@eliminar')->name('grupomenu.eliminar');
    Route::resource('grupomenu', 'GrupoMenuController', array('except' => array('show')));
    /* Rutas de OPCIONMENU */
    Route::post('opcionmenu/buscar', 'OpcionMenuController@buscar')->name('opcionmenu.buscar');
    Route::get('opcionmenu/eliminar/{id}/{listarluego}', 'OpcionMenuController@eliminar')->name('opcionmenu.eliminar');
    Route::resource('opcionmenu', 'OpcionMenuController', array('except' => array('show')));
    /* Rutas de ROL */
    Route::post('rol/buscar', 'RolController@buscar')->name('rol.buscar');
    Route::get('rol/eliminar/{id}/{listarluego}', 'RolController@eliminar')->name('rol.eliminar');
    Route::resource('rol', 'RolController', array('except' => array('show')));
    /* Rutas de ROLPERSONA */
    Route::get('rolpersona', 'RolPersonaController@index')->name('rolpersona');
    Route::post('rolpersona', 'RolPersonaController@store')->name('store_rolpersona');
    /* Rutas de TIPOUSUARIO */
    Route::post('tipousuario/buscar', 'TipoUsuarioController@buscar')->name('tipousuario.buscar');
    Route::get('tipousuario/eliminar/{id}/{listarluego}', 'TipoUsuarioController@eliminar')->name('tipousuario.eliminar');
    Route::resource('tipousuario', 'TipoUsuarioController', array('except' => array('show')));
    /* Rutas de USUARIO */
    Route::post('usuario/buscar', 'UsuarioController@buscar')->name('usuario.buscar');
    Route::get('usuario/eliminar/{id}/{listarluego}', 'UsuarioController@eliminar')->name('usuario.eliminar');
    Route::resource('usuario', 'UsuarioController', array('except' => array('show')));
});


//aca las demas rutas
Route::group(['middleware' => ['auth', 'acceso']], function () {
    /*Dashboard Principal*/
    Route::get('dashboard', 'Gestion\CreditosController@index')->name('dashboard');
    Route::post('creditos/buscar', 'Gestion\CreditosController@buscar')->name('creditos.buscar');
    Route::get('creditos/eliminar/{id}/{listarluego}', 'Gestion\CreditosController@eliminar')->name('creditos.eliminar');
    Route::resource('creditos', 'Gestion\CreditosController', array('except' => array('show')));
    /* Rutas Perfil & Cambio Contraseña */
    Route::get('persona/perfil', 'Admin\UsuarioController@perfil')->name('usuario.perfil');
    Route::post('persona/password/{id}', 'Admin\UsuarioController@cambiarpassword')->name('usuario.cambiarpassword');
    /* Rutas de PERSONA */
    Route::post('persona/buscar', 'Admin\PersonaController@buscar')->name('persona.buscar');
    Route::get('persona/eliminar/{id}/{listarluego}', 'Admin\PersonaController@eliminar')->name('persona.eliminar');
    Route::resource('persona', 'Admin\PersonaController', array('except' => array('show')));
    /* Rutas de BANCO */
    Route::post('banco/buscar', 'Gestion\BancoController@buscar')->name('banco.buscar');
    Route::get('banco/eliminar/{id}/{listarluego}', 'Gestion\BancoController@eliminar')->name('banco.eliminar');
    Route::resource('banco', 'Gestion\BancoController', array('except' => array('show')));
    //Para comandas GERENAR
    Route::post('reportecomanda/buscar', 'Gestion\ReporteComandasController@buscar')->name('reportecomanda.buscar');
    Route::get('reportecomanda/eliminar/{id}/{listarluego}', 'Gestion\ReporteComandasController@eliminar')->name('reportecomanda.eliminar');
    Route::resource('reportecomanda', 'Gestion\ReporteComandasController', array('except' => array('show')));
    //Para comandas Area
    Route::post('reportecomandaarea/buscar', 'Gestion\ReporteComandasAreaController@buscar')->name('reportecomandaarea.buscar');
    Route::get('reportecomandaarea/eliminar/{id}/{listarluego}', 'Gestion\ReporteComandasAreaController@eliminar')->name('reportecomandaarea.eliminar');
    Route::resource('reportecomandaarea', 'Gestion\ReporteComandasAreaController', array('except' => array('show')));
});
