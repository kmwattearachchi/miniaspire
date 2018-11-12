<?php


namespace App\Providers;
use App\Loan;
use App\LoanRepayment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('check_loan_status', function ($attribute, $value, $parameters, $validator) {

            $loan_id = explode('.',$parameters[0])[0];
            $payment = explode('.',$parameters[1])[0];

            $loan_data = getLoanPaymentBalance($loan_id);

            if (abs(($loan_data['paid_amount']-$loan_data['loan_value_at_maturity'])/$loan_data['loan_value_at_maturity']) < 0.00001) {
                $validator->setCustomMessages(['check_loan_status' =>  'The loan is already settled!']);
                return false;
            }elseif($loan_data['paid_amount'] > $loan_data['loan_value_at_maturity']){
                $validator->setCustomMessages(['check_loan_status' =>  'The loan is already settled!']);
                return false;
           }elseif ($loan_data['loan_value_at_maturity'] < ($loan_data['paid_amount']+$payment) ){
               $validator->setCustomMessages(['check_loan_status' =>  'To settle the loan please pay '.($loan_data['loan_value_at_maturity']-$loan_data['paid_amount'])]);
               return false;
           }

           return true;
        });
    }
}