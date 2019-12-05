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
$router->get('/', function () use ($router) {
    return redirect('api/api-docs');
});

$router->group(['', ''], function () use ($router) {
	$router->group(['prefix' => 'condominiums/'], function ($router) {
		/**
		 * Condominius routes
		 */
		$router->get('/', 'CondominiumsController@index');
		$router->post('/', 'CondominiumsController@store');
		$router->get('/{condominiums_id}', 'CondominiumsController@show');
		/**
		 * User routes
		 */
		$router->post('authenticate/', 'AuthenticateController@authenticate');
		$router->get('users/', 'UsersController@index');
		$router->get('users/{documents}', 'UsersController@show');
		$router->post('users/', 'UsersController@store');
		$router->put('users/{documents}', 'UsersController@update');
		$router->delete('users/{documents}', 'UsersController@destroy');
		$router->patch('users/{documents}', 'UsersController@restore');
	});
});