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

Another way to use route
Route::get('/users/{id}', function ($id) {
    return $id;
});
*/

// Route -> Controller -> Model -> Views

/* 
Artisan commands:
Make controller -> php artisan make:controller SomenameController
Make model with migration -> php artisan make:model Singulartablename -m
*/

/*
npm commands:
Compile sass in resources folder -> npm run dev
Compile and watch sass in resources folder -> npm run watch
*/

Route::get('/', 'PagesController@index');

Route::get('/about', 'PagesController@about');

Route::get('/services', 'PagesController@services');

Route::resource('/posts', 'PostsController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
