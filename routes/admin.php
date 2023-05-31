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
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {

    });
});
*/



Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('chat')->name('chat/')->group(static function() {
            Route::get('/','MessagePageController@index')->name('index');
           // Route::get('/{chat}','MessagePageController@show')->name('show');
        });
        ################################  profile ######################################
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
        ################################  user ######################################
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
        Route::prefix('ceo-admin')->name('ceo-admin/')->group(static function() {
            Route::get('/',                                             'CeoAdminsController@index')->name('index');
            Route::get('/create',                                       'CeoAdminsController@create')->name('create');
            Route::post('/',                                            'CeoAdminsController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'CeoAdminsController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'CeoAdminsController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'CeoAdminsController@update')->name('update');
            Route::delete('/{adminUser}',                               'CeoAdminsController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'CeoAdminsController@resendActivationEmail')->name('resendActivationEmail');
        });
        Route::prefix('supervisor-admin')->name('supervisor-admin/')->group(static function() {
            Route::get('/',                                             'SupervisorAdminsController@index')->name('index');
            Route::get('/create',                                       'SupervisorAdminsController@create')->name('create');
            Route::post('/',                                            'SupervisorAdminsController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'SupervisorAdminsController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'SupervisorAdminsController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'SupervisorAdminsController@update')->name('update');
            Route::delete('/{adminUser}',                               'SupervisorAdminsController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'SupervisorAdminsController@resendActivationEmail')->name('resendActivationEmail');
        });
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
        Route::prefix('team-leader-admin')->name('employee-admin/')->group(static function() {
            Route::get('/',                                             'TeamLeaderAdminsController@index')->name('index');
            Route::get('/create',                                       'TeamLeaderAdminsController@create')->name('create');
            Route::post('/',                                            'TeamLeaderAdminsController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'TeamLeaderAdminsController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'TeamLeaderAdminsController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'TeamLeaderAdminsController@update')->name('update');
            Route::delete('/{adminUser}',                               'TeamLeaderAdminsController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'TeamLeaderAdminsController@resendActivationEmail')->name('resendActivationEmail');
        });

        ################################  website ######################################
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
    });
});

/* Auto-generated admin routes */

