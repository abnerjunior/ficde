<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Models\estudiantes;

$router->get('/', function () use ($router) {
    return redirect('api/api-docs');
});

$router->group(['', ''], function () use ($router) {
	$router->group(['prefix' => 'ficde/'], function ($router) {
		/**
		 * User routes
		 */
		$router->post('authenticate/', 'AuthenticateController@authenticate');
		$router->get('users/', 'UsersController@index');

		$router->get('asistencias/', 'AsistenciasController@index');
		$router->get('aulas/', 'AulasController@index');
		$router->get('curso/', 'CursoController@index');
		$router->get('estudiantes_materias/', 'EstudiantesController@index');
		$router->get('estudiantes/', 'EstudiantesController@index');
		$router->get('institucion/', 'InstitucionController@index');
		$router->get('justificados/', 'JustificadosController@index');
		$router->get('materias/', 'MateriasController@index');
		$router->get('modalidades/', 'ModalidadesController@index');
		$router->get('notas/', 'NotasController@index');
		$router->get('pagos_recuperatorios/', 'Pagos_RecuperatoriosController@index');
		$router->get('pagos_semestres/', 'Pagos_SemestresController@index');
		$router->get('recuperatorio/', 'RecuperatorioController@index');
		$router->get('sedes/', 'SedesController@index');
		$router->get('semestres_materias/', 'Semestres_MateriasController@index');
		$router->get('semestres/', 'SemestresController@index');
		$router->get('turnos/', 'TurnosController@index');
		$router->get('usuarios/', 'UsuariosController@index');

		$router->post('turnos/', 'TurnosController@store');
		$router->put('turnos/{turno}', 'TurnosController@update');
		$router->get('turnos/{turno}', 'TurnosController@show');

		$router->post('estudiantes/', 'EstudiantesController@store');
		$router->put('estudiantes/{dni}', 'EstudiantesController@update');
		$router->get('estudiantes/{dni}', 'EstudiantesController@show');


		/** 
		 * existen 5 tipos de rutas
		 * las get, post, put, delete y patch
		 * no tenenos la post que es
		*/

		$router->get('users/{documents}', 'UsersController@show');
		$router->post('users/', 'UsersController@store');
		$router->put('users/{documents}', 'UsersController@update');
		$router->delete('users/{documents}', 'UsersController@destroy');
		$router->patch('users/{documents}', 'UsersController@restore');
	});
});
