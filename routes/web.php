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


Route::get('/', 'GameController@index');
Route::get('/attempts', 'AttemptController@index')->name('guess.attempts');
Route::get('/ranking', 'AttemptController@ranking')->name('games.ranking');


Route::post('/start', 'GameController@start' )->name('game.start');
Route::post('/guess', 'GameController@guess')->name('game.guess');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
