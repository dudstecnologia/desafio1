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



/* ================= Rotas Aluno ================= */

Route::get('/', 'AlunoController@index');
Route::get('/aluno/{id}', 'AlunoController@select');
Route::get('/relatorio', 'AlunoController@relatorio');
Route::post('/aluno', 'AlunoController@store');
Route::post('/aluno/{id}', 'AlunoController@update');
Route::delete('/aluno/{id}', 'AlunoController@delete');

/* ================= Rotas Curso ================= */

Route::get('/curso', 'CursoController@index');
Route::get('/curso/{id}', 'CursoController@select');
Route::post('/curso', 'CursoController@store');
Route::post('/curso/{id}', 'CursoController@update');
Route::delete('/curso/{id}', 'CursoController@delete');

/* ================= Rotas Professor ================= */

Route::get('/professor', 'ProfessorController@index');
Route::get('/professor/{id}', 'ProfessorController@select');
Route::post('/professor', 'ProfessorController@store');
Route::post('/professor/{id}', 'ProfessorController@update');
Route::delete('/professor/{id}', 'ProfessorController@delete');

