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
 Route::get('/team-leader/login', function () {
            return view('team-leader.auth.login');
        });
Route::get('/team-leader', function () {
           // return view('team-leader.auth.login');
            return 'team-leader';
        })->name('team-leader');
*/

Route::middleware(['web'])->group(static function () {
    Route::namespace('App\Http\Controllers\TeamLeader\Auth')->group(static function () {
       Route::get('/team-leader/login', 'LoginController@showLoginForm')->name('team-leader/login');

        Route::post('/team-leader/login', 'LoginController@login');

        Route::any('/team-leader/logout', 'LoginController@logout')->name('team-leader/logout');

        Route::get('/team-leader/password-reset', 'ForgotPasswordController@showLinkRequestForm')->name('team-leader/password/showForgotForm');
        Route::post('/team-leader/password-reset/send', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/team-leader/password-reset/{token}', 'ResetPasswordController@showResetForm')->name('team-leader/password/showResetForm');
        Route::post('/team-leader/password-reset/reset', 'ResetPasswordController@reset');

        Route::get('/team-leader/activation/{token}', 'ActivationController@activate')->name('team-leader/activation/activate');
    });

});
Route::middleware(['web', 'auth:' . config('team-leader-auth.defaults.guard')])->group(static function () {
    Route::namespace('App\Http\Controllers\TeamLeader')->group(static function () {
        Route::get('/team-leader', 'AdminHomepageController@index')->name('team-leader');
        Route::prefix('team-leader')->group(function () {
            // Route::post('/team-leader/wysiwyg-media','WysiwygMediaUploadController@upload')->name('team-leader/admin-ui::wysiwyg-upload');
            Route::post('/upload', 'FileUploadController@upload')->name('team-leader.upload');
            Route::get('/view', 'FileViewController@view')->name('team-leader.view');
        });
    });
});



Route::middleware(['auth:' . config('team-leader-auth.defaults.guard')])->group(static function () {
    Route::prefix('team-leader')->namespace('App\Http\Controllers\TeamLeader')->name('team-leader/')->group(static function() {
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










