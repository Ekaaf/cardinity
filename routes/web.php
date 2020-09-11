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

Route::get('/', array('as' => 'index', 'uses' => 'ProductController@index'));
Route::get('/update-cart', array('as' => 'updateCart', 'uses' => 'ProductController@updateCart'));
Route::get('/cart', array('as' => 'cart', 'uses' => 'ProductController@cart'));
Route::get('/cardinfo', array('as' => 'cardinfo', 'uses' => 'ProductController@cardinfo'));
Route::post('/payment', array('as' => 'payment', 'uses' => 'ProductController@payment'));
Route::get('/test', array('as' => 'test', 'uses' => 'ProductController@test'));

Route::get('/add', array('as' => 'add', 'uses' => 'PersonController@add'));
Route::post('/save_person', array('as' => 'save_person', 'uses' => 'PersonController@savePerson'));
Route::get('/get_persons', array('as' => 'getPersons', 'uses' => 'PersonController@getPersons'));
Route::get('/get_cities_by_country', array('as' => 'get_cities_by_country', 'uses' => 'PersonController@getCitiesByCountry'));
Route::get('/view/{id}', array('as' => 'view', 'uses' => 'PersonController@view'));
Route::get('/edit/{id}', array('as' => 'edit', 'uses' => 'PersonController@edit'));
Route::get('/person-delete/{id}', array('as' => 'person-delete', 'uses' => 'PersonController@personDelete'));