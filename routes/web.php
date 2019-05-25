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

Route::group(['prefix' => parseLocale(),
    'as' => 'l.'], function () {

    //Auth::routes();
    // Página inicial
    Route::get('/', 'WelcomeController@home')
        ->name('home');

    Route::post('/', 'WelcomeController@searchHash')
        ->name('search_hash');

    Route::group(['prefix' => 'research_forms',
        'as' => 'research_forms.'], function () {

        Route::get('/{schoolHash}', 'ResearchFormsController@index')
            ->where(['schoolHash' => '[a-zA-Z0-9]+'])
            ->name('index');

        Route::get('/{page}', 'ResearchFormsController@showPage')
            ->where(['page' => '[0-9]+'])
            ->name('show_page');

    });

});
