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

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('auth/verify/{token}', 'Auth\RegisterController@verify');
Route::get('auth/send-verification', 'Auth\RegisterController@sendVerification');
Route::resource('books', 'BooksController');
Route::get('settings/profile', 'SettingsController@profile')->name('profile');
Route::get('settings/profile/edit', 'SettingsController@editProfile')->name('edit.profile');
Route::get('settings/password', 'SettingsController@editPassword')->name('edit.pass');
Route::post('settings/password', 'SettingsController@updatePassword')->name('update.pass');
Route::post('settings/profile', 'SettingsController@updateProfile')->name('update.profile');
Route::get('books/{book}/borrow', ['middleware' => ['auth', 'role:member'], 'uses' => 'BooksController@borrow'])->name('books.borrow');
Route::get('/transaction', ['middleware' => ['auth', 'role:member'], 'uses' => 'HomeController@membertransaction'])->name('transaction.member');
Route::group(['middleware' => 'web'], function () {
    // prefik untuk menambah awalan /admin di url dan auth untuk harus login
    Route::group(['prefix'=>'admin', 'middleware'=>['auth','role:admin']], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('authors', 'AuthorsController');
        Route::get('/transaction', 'HomeController@transaction')->name('transaction.admin');
        Route::get('books/{book}/return', ['uses' => 'BooksController@returnBack' ])->name('books.return');
        Route::resource('members', 'MembersController');
    });
});