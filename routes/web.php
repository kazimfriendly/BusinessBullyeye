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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/modules', 'ModuleController@index')->middleware('auth');

Route::get('/modules/add', 'ModuleController@create')->middleware('auth');

Route::get('modules/{module_id?}','ModuleController@edit')->middleware('auth');
Route::post('modules','ModuleController@store')->middleware('auth');
Route::put('modules/{module_id?}','ModuleController@update')->middleware('auth');
Route::delete('modules/{module_id?}','ModuleController@destroy')->middleware('auth');
Route::put('modules/make_live/{module_id?}','ModuleController@makeLive')->middleware('auth');
Route::get('modules/live','ModuleController@getLive')->middleware('auth');
Route::get('modules/preview/{module_id?}','ModuleController@show')->middleware('auth');
Route::post('modules/make_copy/{module_id}','ModuleController@makeCopy')->middleware('auth');


Route::post('/documents/upload', 'DocumentController@docUploadPost')->middleware('auth');
Route::get('/documents/list/{module_id?}', 'DocumentController@listModuleDoc')->middleware('auth');
Route::delete('/documents/{doc_id?}', 'DocumentController@destroy')->middleware('auth');


Route::group(['prefix' => 'questions','middleware' => 'auth'], function () {
     Route::put('sort','QuestionController@sort');
    Route::get('list/{module_id?}', 'QuestionController@grid');
    Route::post('/','QuestionController@store');
    Route::put('{question_id}','QuestionController@update');
    Route::get('{question_id}','QuestionController@show');
    Route::delete('{question_id}','QuestionController@destroy');
   
    
});

Route::group(['prefix' => 'packages','middleware' => 'auth'], function () {
    Route::get('/add', 'PackageController@create');
    Route::get('/', 'PackageController@index');
    Route::post('/','PackageController@store');
    Route::put('{package_id}','PackageController@update');
    Route::get('{package_id}','PackageController@show');
    Route::delete('{package_id}','PackageController@destroy');
    Route::get('/linked_clients/{package_id}','PackageController@showLinkedClients');
    Route::post('/make_copy/{package_id}','PackageController@makeCopy');
    Route::post('/status/{package_id}','PackageController@updateStatus');
    Route::get('/assign_coach/{package_id}','PackageController@assignCoachForm');
    Route::post('/assign_coach','PackageController@assignCoach');
    Route::get('/view/{package_id}','PackageController@view');
    

});

Route::group(['prefix' => 'clients','middleware' => 'auth'], function () {
    Route::get('/active_packages','ClientController@activePackages');
    Route::get('/', 'ClientController@index');
    Route::post('/','ClientController@store');
    Route::post('/addExisting','ClientController@storeExisting');
    Route::put('{package_id}','ClientController@update');
//    Route::get('{package_id}','ClientController@show');
    Route::delete('{client_id}','ClientController@destroy');
    
    
});

Route::group(['prefix' => 'coaches','middleware' => 'auth'], function () {
    Route::get('/', 'CoacheController@index');
    Route::post('/','CoacheController@store');
    Route::get('/active_packages','CoacheController@activePackages');
    Route::delete('/{coach_id}','CoacheController@destroy');
    Route::post('/status','CoacheController@updateStatus');
    Route::post('/upload','CoacheController@uploadEditor');
});

Route::group(['prefix' => 'assigned','middleware' => 'auth'], function () {
    Route::post('/sendtoclient/{assigned_id}', 'AssignmentController@sendtoclient');
    Route::post('/sendtocoach/{assigned_id}', 'AssignmentController@sendtocoach');
    Route::post('/savecontinue/{assigned_id}', 'AssignmentController@savecontinue');
    Route::get('/{assigned_id}', 'AssignmentController@show');
    Route::post('/{package_id}/{module_id}', 'AssignmentController@store');
    Route::post('/update_status', 'AssignmentController@updateStatus');
   
});

Route::group(['prefix' => 'profile','middleware' => 'auth'], function () {
    Route::get('/', 'ProfileController@index');
    Route::post('/','ProfileController@store');
    Route::put('/update/{user_id}','ProfileController@update');
    Route::get('/edit/{user_id}','ProfileController@edit');
    Route::get('/{user_id}','ProfileController@show');
    Route::delete('{user_id}','ProfileController@destroy');
    Route::get('/linked_clients/{user_id}','ProfileController@showLinkedClients');
});
