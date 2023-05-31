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
 Route::get('/support/login', function () {
            return view('support.auth.login');
        });
Route::get('/support', function () {
           // return view('support.auth.login');
            return 'support';
        })->name('support');
*/

Route::middleware(['web'])->group(static function () {
    Route::namespace('App\Http\Controllers\Support\Auth')->group(static function () {
       Route::get('/support/login', 'LoginController@showLoginForm')->name('support/login');

        Route::post('/support/login', 'LoginController@login');

        Route::any('/support/logout', 'LoginController@logout')->name('support/logout');

        Route::get('/support/password-reset', 'ForgotPasswordController@showLinkRequestForm')->name('support/password/showForgotForm');
        Route::post('/support/password-reset/send', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/support/password-reset/{token}', 'ResetPasswordController@showResetForm')->name('support/password/showResetForm');
        Route::post('/support/password-reset/reset', 'ResetPasswordController@reset');

        Route::get('/support/activation/{token}', 'ActivationController@activate')->name('support/activation/activate');
    });

});
Route::middleware(['web', 'auth:' . config('support-auth.defaults.guard')])->group(static function () {
    Route::namespace('App\Http\Controllers\Support')->group(static function () {
        Route::get('/support', 'MessagePageController@index')->name('support');
        Route::prefix('support')->group(function () {
            // Route::post('/support/wysiwyg-media','WysiwygMediaUploadController@upload')->name('support/admin-ui::wysiwyg-upload');
            Route::post('/upload', 'FileUploadController@upload')->name('support.upload');
            Route::get('/view', 'FileViewController@view')->name('support.view');
        });
    });

});



Route::middleware(['auth:' . config('support-auth.defaults.guard')])->group(static function () {
    Route::prefix('support')->namespace('App\Http\Controllers\Support')->name('support/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
        Route::get('/chat','MessagePageController@index')->name('index');
        Route::prefix('chats')->name('chats/')->group(static function() {
            Route::get('/',                                             'ChatsController@index')->name('index');
            Route::get('/create',                                       'ChatsController@create')->name('create');
            Route::post('/',                                            'ChatsController@store')->name('store');
            Route::get('/{chat}/edit',                                  'MessagePageController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ChatsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{chat}',                                      'ChatsController@update')->name('update');
            Route::delete('/{chat}',                                    'ChatsController@destroy')->name('destroy');
        });

        Route::prefix('messages')->name('messages/')->group(static function() {
           // Route::get('/',                                             'MessagesController@index')->name('index');
            Route::get('/',                                             'MessagePageController@show')->name('index');
            Route::get('/create',                                       'MessagesController@create')->name('create');
        Route::post('/',                                            'MessagePageController@store')->name('store');
            Route::get('/{message}/edit',                               'MessagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MessagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{message}',                                   'MessagesController@update')->name('update');
            Route::delete('/{message}',                                 'MessagesController@destroy')->name('destroy');
        });

        Route::get('/translations', 'TranslationsController@index');
        Route::get('/translations/export', 'TranslationsController@export')->name('translations/export');
        Route::post('/translations/import', 'TranslationsController@import')->name('translations/import');
        Route::post('/translations/import/conflicts', 'TranslationsController@importResolvedConflicts')->name('translations/import/conflicts');
        Route::post('/translations/rescan', 'RescanTranslationsController@rescan');
        Route::post('/translations/{translation}', 'TranslationsController@update');
    });
});










