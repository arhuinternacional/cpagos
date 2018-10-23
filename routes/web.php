<?php

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
Route::resource('/','FrontController');
Route::get('/value','FrontController@valor');

 Route::group(['prefix' => '/admin/filemanager', 'middleware' => ['web', 'auth']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });

Auth::routes();

/*Route::get('/', function () {
    return view('welcome');
});*/


//Route::group(['middleware' => ['role:admin']], function () {

	Route::get('/admin','AdminController@index')->middleware('auth');
	Route::get('/admin/dashboard','AdminController@dashboard')->middleware('auth');
	Route::get('/admin/tests','AdminController@testing');
	
	
	    //

	//Rutas Proveedores 

	Route::get('/admin/proveedor/proveedorget', 'ProveedorController@getall');
	Route::post('/admin/proveedor/mail', 'ProveedorController@mail');
	Route::get('/admin/proveedorclose', 'ProveedorController@getprovclose');
	Route::post('/admin/proveedor/setproveedores', 'ProveedorController@setprov')->name('importprov');
	Route::get('/admin/verifprov/{id}', 'ProveedorController@changeVerify');
	Route::get('/admin/historico', 'ProveedorController@historic');
	Route::get('/admin/historic', 'ProveedorController@gethistoric');
	Route::get('/admin/showact', 'ProveedorController@showActivity');
	Route::get('/admin/proveedor/tablas', 'ProveedorController@tablas');
	Route::resource('/admin/proveedor','ProveedorController');


	//Rutas Costos

	Route::get('/admin/costos/aprovacion', 'CostosController@aprovarOp');
	Route::get('/admin/mailcostos', 'CostosController@mail');
	Route::get('/admin/costos/historial', 'CostosController@historic');
	Route::get('/admin/costos/aprov', 'CostosController@approv');
	Route::post('/admin/costos/aprobar', 'CostosController@apro');
	Route::get('/admin/costos/gethistoric', 'CostosController@gethistorics');
	Route::get('/admin/costos/getaprob', 'CostosController@getApro');
	Route::get('/admin/costos/getcostos', 'CostosController@getCostos');
	Route::get('/admin/shows', 'CostosController@shows');
	Route::post('/admin/costos/setcostos', 'CostosController@importExcel')->name('importcost');
	Route::resource('/admin/costos','CostosController');

	//Rutas Incidentes Costos

	Route::get('/admin/getcostosincidents', 'CostoIncidentsController@getIncidents');
	Route::resource('/admin/incidentescosto','CostoIncidentsController');

	// Routes Close2U
	Route::get('/admin/facturas/factclose', 'CloseController@index');
	Route::get('/admin/facturas/getfacts', 'CloseController@getfact');
	Route::post('/admin/facturas/downloadfact', 'CloseController@getFacturas')->name('downloadfact');
	Route::post('/admin/facturas/importclose', 'CloseController@importExcel')->name('importclose2');

	//Rutas Facturas

	Route::post('/admin/facturas/getlist', 'FacturasController@lists');
	Route::get('/admin/facturas/getfacturas', 'FacturasController@facturas');
	Route::get('/admin/facturas/test', 'FacturasController@test');
	Route::post('/admin/facturas/generate', 'FacturasController@generateFact');
	Route::post('/admin/facturas/import', 'FacturasController@importExcel')->name('importFact');
	Route::get('/admin/facturas/setfact', 'CloseController@setFacts')->name('generatecost');

	Route::resource('/admin/facturas','FacturasController');

	//Routes Drivers
	Route::resource('/admin/drivers', 'DriverController');

	//Routes Factura Incidentes
	Route::get('/admin/facturaincidentes/getfacturas', 'FacturaIncidentController@getFact');
	Route::resource('/admin/facturaincidentes', 'FacturaIncidentController');


	//Routes Pagos

	Route::get('/admin/pagos/getlist','PagosController@lists');
	Route::get('/admin/pagos/verificacion','PagosController@verificate');
	Route::get('/admin/pagos/getpagos','PagosController@getPag');
	Route::get('/admin/pagos/incidentes','PagosController@incidentes');
	Route::get('/admin/pagos/getincident','PagosController@getInci');
	Route::get('/admin/pagos/getverificat','PagosController@getVerif');
	Route::post('/admin/pagos/getverificat','PagosController@setVerif');
	Route::post('/admin/pagos/generate','PagosController@generate');
	Route::resource('/admin/pagos','PagosController');

	Route::get('/testing', 'AdminController@testing');
	Route::get('/messages', 'AdminController@fetch');


	//Rutas Administracion
	Route::resource('/admin/administracion', 'AdministracionController');

	//Rutas Usuarios
	Route::get('/admin/getusers', 'UsuarioController@GetUser');
	Route::resource('/admin/usuario','UsuarioController');

//});