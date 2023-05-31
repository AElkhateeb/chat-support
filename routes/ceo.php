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
 return Redirect::to(Config::get('app.default_language'));
    return view('welcome');
});
*/


Route::middleware(['web'])->group(static function () {
    Route::namespace('App\Http\Controllers\Ceo\Auth')->group(static function () {
        Route::get('/ceo/login', 'LoginController@showLoginForm')->name('ceo/login');

        Route::post('/ceo/login', 'LoginController@login');

        Route::any('/ceo/logout', 'LoginController@logout')->name('ceo/logout');

        Route::get('/ceo/password-reset', 'ForgotPasswordController@showLinkRequestForm')->name('ceo/password/showForgotForm');
        Route::post('/ceo/password-reset/send', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/ceo/password-reset/{token}', 'ResetPasswordController@showResetForm')->name('ceo/password/showResetForm');
        Route::post('/ceo/password-reset/reset', 'ResetPasswordController@reset');

        Route::get('/ceo/activation/{token}', 'ActivationController@activate')->name('ceo/activation/activate');
    });
    Route::prefix('ceo')->namespace('App\Http\Controllers\Ceo')->group(function () {
        // Route::post('/ceo/wysiwyg-media','WysiwygMediaUploadController@upload')->name('ceo/admin-ui::wysiwyg-upload');
        Route::post('/upload', 'FileUploadController@upload')->name('ceo.upload');
        Route::get('/view', 'FileViewController@view')->name('ceo.media::view');
    });
});
Route::middleware(['web', 'auth:' . config('ceo-auth.defaults.guard')])->group(static function () {
    Route::namespace('App\Http\Controllers\Ceo')->group(static function () {
        Route::get('/ceo', 'AdminHomepageController@index')->name('ceo');

    });
});



Route::middleware(['auth:' . config('ceo-auth.defaults.guard')])->group(static function () {
    Route::prefix('ceo')->namespace('App\Http\Controllers\Ceo')->name('ceo/')->group(static function() {
        ################################  profile ######################################
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
        ################################  user ######################################
        Route::prefix('support-admin')->name('support-admin/')->group(static function() {
            Route::get('/',                                             'SupportAdminsController@index')->name('index');
            Route::get('/create',                                       'SupportAdminsController@create')->name('create');
            Route::post('/',                                            'SupportAdminsController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'SupportAdminsController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'SupportAdminsController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'SupportAdminsController@update')->name('update');
            Route::delete('/{adminUser}',                               'SupportAdminsController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'SupportAdminsController@resendActivationEmail')->name('resendActivationEmail');
        });
        Route::get('/chat','MessagePageController@index')->name('index');
        ################################  website ######################################
        


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
          //  Route::get('/',                                             'MessagesController@index')->name('index');
           Route::get('/',                                             'MessagePageController@show')->name('index');
            Route::get('/create',                                       'MessagesController@create')->name('create');
            Route::post('/',                                            'MessagePageController@store')->name('store');
            Route::get('/{message}/edit',                               'MessagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MessagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{message}',                                   'MessagesController@update')->name('update');
            Route::delete('/{message}',                                 'MessagesController@destroy')->name('destroy');
        });

        
        Route::prefix('customers')->name('customers/')->group(static function() {
            Route::get('/',                                             'CustomersController@index')->name('index');
            Route::get('/create',                                       'CustomersController@create')->name('create');
            Route::post('/',                                            'CustomersController@store')->name('store');
            Route::get('/{customer}/edit',                              'CustomersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CustomersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{customer}',                                  'CustomersController@update')->name('update');
            Route::delete('/{customer}',                                'CustomersController@destroy')->name('destroy');
        });

        Route::prefix('boot-admins')->name('boot-admins/')->group(static function() {
            Route::get('/',                                             'BootAdminsController@index')->name('index');
            Route::get('/create',                                       'BootAdminsController@create')->name('create');
            Route::post('/',                                            'BootAdminsController@store')->name('store');
            Route::get('/{bootAdmin}/edit',                             'BootAdminsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BootAdminsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{bootAdmin}',                                 'BootAdminsController@update')->name('update');
            Route::delete('/{bootAdmin}',                               'BootAdminsController@destroy')->name('destroy');
        });
            Route::prefix('incomes')->name('incomes/')->group(static function() {
            Route::get('/',                                             'IncomesController@index')->name('index');
            Route::get('/create',                                       'IncomesController@create')->name('create');
            Route::post('/',                                            'IncomesController@store')->name('store');
            Route::get('/{income}/edit',                                'IncomesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'IncomesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{income}',                                    'IncomesController@update')->name('update');
            Route::delete('/{income}',                                  'IncomesController@destroy')->name('destroy');
        });
            Route::prefix('replies')->name('replies/')->group(static function() {
            Route::get('/',                                             'RepliesController@index')->name('index');
            Route::get('/create',                                       'RepliesController@create')->name('create');
            Route::post('/',                                            'RepliesController@store')->name('store');
            Route::get('/{reply}/edit',                                 'RepliesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RepliesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{reply}',                                     'RepliesController@update')->name('update');
            Route::delete('/{reply}',                                   'RepliesController@destroy')->name('destroy');
        });

        ################################  translations ######################################
        Route::get('/translations', 'TranslationsController@index');
        Route::get('/translations/export', 'TranslationsController@export')->name('translations/export');
        Route::post('/translations/import', 'TranslationsController@import')->name('translations/import');
        Route::post('/translations/import/conflicts', 'TranslationsController@importResolvedConflicts')->name('translations/import/conflicts');
        Route::post('/translations/rescan', 'RescanTranslationsController@rescan');
        Route::post('/translations/{translation}', 'TranslationsController@update');
    });
});


