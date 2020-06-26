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

Route::get('/', function () {
    return view('index');
});
Route::get('/index', function () {
    return view('index');
});

Route::get('/otras-fiestas', function () {
    return view('otras-fiestas');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/mainFifteen', function () {
    return view('mainFifteen');
});

Route::get('/templos_y_jefaturas', function () {
    return view('templos_y_jefaturas');
});

Route::get('/main_bodas', function () {
    return view('main_bodas');
});

Route::get('/documentacion_bodas', function () {
    return view('documentacion_bodas');
});

Route::get('/wedding_courses', function () {
    return view('wedding_courses');
});


Route::get('/tips_boda', function () {
    return view('tips_boda');
});

Route::get('/form_inscripcion_cursos_matrimoniales', function () {
    return view('form_inscripcion_cursos_matrimoniales');
});