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
Route::group(['prefix' => 'v1/loan', 'middleware' => ['auth.token']], function () {
    Route::get('get-loans', 'LoanController@getLoans');
    Route::get('get-loan/{id}', 'LoanController@getLoan');
    Route::post('create-new-loan', 'LoanController@createNewLoan');
    Route::post('update-loan/{id}', 'LoanController@updateLoanDetails');
    Route::post('repayment/{loan_id}', 'LoanPaymentDetailsController@makeNewPayment');
    Route::get('payment/history/{loan_id}', 'LoanPaymentDetailsController@loanPaymentHistory');
});