<?php
use App\Mail\SendMailable;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/changelangouage', 'HomeController@changelangouage')->middleware('setlocale')->name('changelangouage');

Route::group(['prefix' => '{locale}','middleware' => 'setlocale'], function() {
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

});

Route::group([ 'prefix' => '{locale}' ,'middleware'=>['setlocale','auth','role:Super Admin']], function () { 

	Route::resource('permissions', 'PermissionController') ;
	Route::resource('roles', 'RoleController') ;

});
Route::group([ 'prefix' => '{locale}' , 'middleware'=>['setlocale','auth','chk_permissions']], function () { 
	Route::resource('admins', 'UsersController') ;
	Route::get('/show', 'FunctionSiteController@show')->name('functions.show');
	Route::post('/save/{id}', 'FunctionSiteController@save')->name('functions.add_delete');
	Route::resource('tickets', 'TicketController') ;
	Route::get('/tickets/open/{id}', 'TicketController@open')->name('tickets.open');
	Route::get('/tickets/close/{id}', 'TicketController@close')->name('tickets.close');
	Route::post('/tickets/reopen/{id}', 'TicketController@reopen')->name('tickets.reopen'); 
});

Route::group(['prefix' => '{locale}' , 'middleware'=>['setlocaley','auth','is_owner']], function () { 

    Route::get('/tickets/change/{id}', 'TicketController@change')->name('tickets.change'); 
    Route::put('/tickets/savechange/{id}', 'TicketController@savechange')->name('tickets.savechange'); 
    Route::get('/tickets/ownertickets/{id}', 'TicketController@ownertickets')->name('tickets.ownertickets'); 
	Route::DELETE('/tickets/destroyownerticket/{id}', 'TicketController@destroyownerticket')->name('tickets.destroyownerticket'); 
	Route::get('/addticket', 'TicketController@addticket')->name('tickets.addticket');
    Route::post('/tickets/save', 'TicketController@save')->name('tickets.save'); 
});
Route::group(['prefix' => '{locale}', 'middleware' => 'setlocale'], function() {
Route::get('mytickets/{id}',['uses'=>'TicketController@mytickets','middleware'=>['auth' ,'chk_my_ticket_permission']])->name('tickets.mytickets');
Route::get('assignedtickets/{id}',['uses'=>'TicketController@assignedtickets','middleware'=>['auth' ,'admin']])->name('tickets.assignedtickets');
Route::get('dashboard/{id}',['uses'=>'TicketController@dashboard','middleware'=>['auth' ,'admin']])->name('tickets.dashboard');
Route::get('/search', 'TicketController@search')->name('tickets.search');
});