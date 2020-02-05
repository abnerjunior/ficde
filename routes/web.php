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
    return redirect('api/ficde');
});

$router->group(['', ''], function () use ($router) {
	$router->group(['prefix' => 'ficde/'], function ($router) {
		/**
		 * User routes
		 */
		$router->post('authenticate/', 'AuthenticateController@authenticate');

		$router->get('asistencias/', 'AsistenciasController@index');
		$router->post('asistencias/', 'AsistenciasController@store');
		$router->put('asistencias/{aula}', 'AsistenciasController@update');
		$router->get('asistencias/{aula}', 'AsistenciasController@show');
        $router->delete('asistencias/{aula}', 'AsistenciasController@destroy');
        
		$router->get('aulas/', 'AulasController@index');
		$router->post('aulas/', 'AulasController@store');
		$router->put('aulas/{aula}', 'AulasController@update');
		$router->get('aulas/{aula}', 'AulasController@show');
		$router->delete('aulas/{aula}', 'AulasController@destroy');

		$router->get('cursos/', 'CursosController@index');
		$router->post('cursos/', 'CursosController@store');
		$router->put('cursos/{cod_curso}', 'CursosController@update');
		$router->get('cursos/{cod_curso}', 'CursosController@show');
		$router->delete('cursos/{cod_curso}', 'CursosController@destroy');

		$router->get('estudiantes_materias/', 'Estudiantes_MateriasController@index');		
		$router->post('estudiantes_materias/', 'Estudiantes_MateriasController@store');
		$router->put('estudiantes_materias/{id_estudiante}', 'Estudiantes_MateriasController@update');
		$router->get('estudiantes_materias/{id_estudiante}', 'Estudiantes_MateriasController@show');
		$router->delete('estudiantes_materias/{id_estudiante}', 'Estudiantes_MateriasController@destroy');
        
		$router->get('estudiantes/', 'EstudiantesController@index');
		$router->post('estudiantes/', 'EstudiantesController@store');
		$router->put('estudiantes/{dni}', 'EstudiantesController@update');
		$router->get('estudiantes/{dni}', 'EstudiantesController@show');
		$router->delete('estudiantes/{dni}', 'EstudiantesController@destroy');


		$router->get('institucion/', 'InstitucionController@index');
		$router->post('institucion/', 'InstitucionController@store');
		$router->put('institucion/{nombre}', 'InstitucionController@update');
		$router->get('institucion/{nombre}', 'InstitucionController@show');

		$router->get('justificados/', 'JustificadosController@index');
		$router->post('justificados/', 'JustificadosController@store');
		$router->put('justificados/{materia}', 'JustificadosController@update');
		$router->get('justificados/{materia}', 'JustificadosController@show');

		$router->get('materias/', 'MateriasController@index');
		$router->post('materias/', 'MateriasController@store');
		$router->put('materias/{id_asistencia}', 'MateriasController@update');
		$router->get('materias/{id_asistencia}', 'MateriasController@show');
		$router->delete('materias/{cod_materia}', 'MateriasController@destroy');

		$router->get('modalidades/', 'ModalidadesController@index');
		$router->post('modalidades/', 'ModalidadesController@store');
		$router->put('modalidades/{modalidad}', 'ModalidadesController@update');
		$router->get('modalidades/{modalidad}', 'ModalidadesController@show');
		$router->delete('modalidades/{modalidad}', 'ModalidadesController@destroy');

		$router->get('notas/', 'NotasController@index');
		$router->post('notas/', 'NotasController@store');
		$router->put('notas/{id_nota}', 'NotasController@update');
		$router->get('notas/{id_nota}', 'NotasController@show');
        $router->delete('notas/{cod_nota}', 'NotasController@destroy');
        
		$router->get('pagos_recuperatorios/', 'Pagos_RecuperatoriosController@index');

		$router->get('pagos_semestres/', 'Pagos_SemestresController@index');

		$router->get('recuperatorios/', 'RecuperatorioController@index');
		$router->post('recuperatorios/', 'RecuperatorioController@store');
		$router->put('recuperatorios/{id_nota}', 'RecuperatorioController@update');
		$router->get('recuperatorios/{id_nota}', 'RecuperatorioController@show');
		
		$router->get('sedes/', 'SedesController@index');
		$router->post('sedes/', 'SedesController@store');
		$router->put('sedes/{id_estudiante}', 'SedesController@update');
		$router->get('sedes/{id_estudiante}', 'SedesController@show');
		$router->delete('sedes/{id_estudiante}', 'SedesController@destroy');

		$router->get('semestres_materias/', 'Semestres_MateriasController@index');
		$router->post('semestres_materias/', 'Semestres_MateriasController@store');
		$router->put('semestres_materias/{id_semestres}', 'Semestres_MateriasController@update');
		$router->get('semestres_materias/{id_semestres}', 'Semestres_MateriasController@show');
        $router->delete('semestres_materias/{id_semestres}', 'Semestres_MateriasController@destroy');
		
        $router->get('semestres/', 'SemestresController@index');
		$router->post('semestres/', 'SemestresController@store');
		$router->put('semestres/{cod_sm}', 'SemestresController@update');
		$router->get('semestres/{cod_sm}', 'SemestresController@show');
        $router->delete('semestres/{cod_sm}', 'SemestresController@destroy');
        
		$router->get('turnos/', 'TurnosController@index');
		$router->post('turnos/', 'TurnosController@store');
		$router->put('turnos/{turno}', 'TurnosController@update');
		$router->get('turnos/{turno}', 'TurnosController@show');
		$router->delete('turnos/{turno}', 'TurnosController@destroy');

		$router->get('usuarios/', 'UsuariosController@index');
		$router->get('usuarios/{dni}', 'UsuariosController@show');
		$router->post('usuarios/', 'UsuariosController@store');
		$router->put('usuarios/{dni}', 'UsuariosController@update');
		$router->delete('usuarios/{dni}', 'UsuariosController@destroy');
		$router->patch('usuarios/{dni}', 'UsuariosController@restore');

		
		$router->get('Reporte_Inscripcion/', 'ReportesController@RGI');
		$router->get('Reporte_Inscripcion/{dni}', 'ReportesController@BRI');
		
		$router->get('Reporte_aprobacion/{dni}', 'ReportesController@BRI');


		$router->get('horarios/', 'HorariosController@index');
		$router->post('horarios/', 'HorariosController@store');
		$router->put('horarios/{aula}', 'HorariosController@update');
		$router->get('horarios/{aula}', 'HorariosController@show');
        $router->delete('horarios/{aula}', 'HorariosController@destroy');
        

		/** 
		 * existen 5 tipos de rutas
		 * las get, post, put, delete y patch
		 * no tenenos la post que es
		*/

	});
});
