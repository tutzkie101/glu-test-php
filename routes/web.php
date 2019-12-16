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

/*
 * List of Routes for the task group
 *
 */
Route::prefix('tasks')->namespace('Tasks')->group( function () {

    Route::get('nextPriority','TasksController@nextPriority');
    Route::get('get/{id}','TasksController@read');
    Route::get('get','TasksController@list');
    Route::post('store','TasksController@store');

});

/*
 * List of Routes for the processor group
 */
Route::prefix('processor')->namespace('Processor')->group( function () {

    Route::get('get/{id}','ProcessorController@read');
    Route::get('get','ProcessorController@list');
    Route::get('average','ProcessorController@averageProcDuration');
    Route::post('proc','ProcessorController@process');

});
