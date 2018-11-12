<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1/loan-user', 'middleware' => ['auth.token']], function () {
    Route::get('get-loan-users', 'LoanUserController@getLoanUsers');
    Route::get('get-loan-user/{id}', 'LoanUserController@getLoanUser');
    Route::post('create-loan-user', 'LoanUserController@createLoanUser');
    Route::post('update-loan-user/{id}', 'LoanUserController@updateLoanUser');
});