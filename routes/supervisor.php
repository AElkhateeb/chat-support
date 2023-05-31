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
|Route::get('/', function () {
    return view('welcome');
});
 Route::get('/supervisor/login', function () {
            return view('supervisor.auth.login');
        });
Route::get('/supervisor', function () {
           // return view('supervisor.auth.login');
            return 'supervisor';
        })->name('supervisor');
*/

Route::middleware(['web'])->group(static function () {
    Route::namespace('App\Http\Controllers\Supervisor\Auth')->group(static function () {
       Route::get('/supervisor/login', 'LoginController@showLoginForm')->name('supervisor/login');

        Route::post('/supervisor/login', 'LoginController@login');

        Route::any('/supervisor/logout', 'LoginController@logout')->name('supervisor/logout');

        Route::get('/supervisor/password-reset', 'ForgotPasswordController@showLinkRequestForm')->name('supervisor/password/showForgotForm');
        Route::post('/supervisor/password-reset/send', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/supervisor/password-reset/{token}', 'ResetPasswordController@showResetForm')->name('supervisor/password/showResetForm');
        Route::post('/supervisor/password-reset/reset', 'ResetPasswordController@reset');

        Route::get('/supervisor/activation/{token}', 'ActivationController@activate')->name('supervisor/activation/activate');
    });

});
Route::middleware(['web', 'auth:' . config('supervisor-auth.defaults.guard')])->group(static function () {
    Route::namespace('App\Http\Controllers\Supervisor')->group(static function () {
        Route::get('/supervisor', 'AdminHomepageController@index')->name('supervisor');
        Route::prefix('supervisor')->group(function () {
            // Route::post('/supervisor/wysiwyg-media','WysiwygMediaUploadController@upload')->name('supervisor/admin-ui::wysiwyg-upload');
            Route::post('/upload', 'FileUploadController@upload')->name('supervisor.upload');
            Route::get('/view', 'FileViewController@view')->name('supervisor.view');
        });
    });

});



Route::middleware(['auth:' . config('supervisor-auth.defaults.guard')])->group(static function () {
    Route::prefix('supervisor')->namespace('App\Http\Controllers\Supervisor')->name('supervisor/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
        Route::get('/chat','MessagePageController@index')->name('index');
        Route::prefix('chats')->name('chats/')->group(static function() {
            Route::get('/',                                             'ChatsController@index')->name('index');
            Route::get('/create',                                       'ChatsController@create')->name('create');
            Route::post('/',                                            'ChatsController@store')->name('store');
            Route::get('/{chat}/edit',                                  'ChatsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ChatsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{chat}',                                      'ChatsController@update')->name('update');
            Route::delete('/{chat}',                                    'ChatsController@destroy')->name('destroy');
        });

        Route::prefix('messages')->name('messages/')->group(static function() {
            Route::get('/',                                             'MessagesController@index')->name('index');
            Route::get('/create',                                       'MessagesController@create')->name('create');
            Route::post('/',                                            'MessagesController@store')->name('store');
            Route::get('/{message}/edit',                               'MessagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MessagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{message}',                                   'MessagesController@update')->name('update');
            Route::delete('/{message}',                                 'MessagesController@destroy')->name('destroy');
        });

        Route::prefix('clients')->name('clients/')->group(static function() {
            Route::get('/',                                             'ClientsController@index')->name('index');
            Route::get('/create',                                       'ClientsController@create')->name('create');
            Route::post('/',                                            'ClientsController@store')->name('store');
            Route::get('/{client}/edit',                                'ClientsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ClientsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{client}',                                    'ClientsController@update')->name('update');
            Route::delete('/{client}',                                  'ClientsController@destroy')->name('destroy');
        });

        Route::get('/translations', 'TranslationsController@index');
        Route::get('/translations/export', 'TranslationsController@export')->name('translations/export');
        Route::post('/translations/import', 'TranslationsController@import')->name('translations/import');
        Route::post('/translations/import/conflicts', 'TranslationsController@importResolvedConflicts')->name('translations/import/conflicts');
        Route::post('/translations/rescan', 'RescanTranslationsController@rescan');
        Route::post('/translations/{translation}', 'TranslationsController@update');
    });
});










