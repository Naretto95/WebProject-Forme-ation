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

Route::get('/', 'HomeController@index')->name('home');

Route::post('/', 'HomeController@search')->name('home.search');

Route::view('/about', 'pages.about')->name('about');

Auth::routes(['verify' => true]);

Route::resource('trainings', 'TrainingsController');

Route::get('/dashboard', 'ParticipantsController@index')->name('dashboard');

Route::resource('participants', 'ParticipantsController');

Route::resource('users', 'UsersController')->middleware(['auth', 'super-admin']);

Route::put('/trainings/{training}/published', 'TrainingsController@published')->name('trainings.published');

Route::post('/auto_complete','TrainingsController@auto_complete')->name('auto_complete');

Route::post('/auto_completebis','HomeController@auto_complete')->name('auto_completebis');