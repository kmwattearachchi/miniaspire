<?php

/**
 * Return the loan balance and loan_value_at_maturity
 *
 * @param $loan_id
 * @return mixed
 */
function getLoanPaymentBalance($loan_id = false)
{
    $loan = \App\Loan::find($loan_id);
    $data['paid_amount'] = 0;

    //Get the full repayment amount at the maturity.
    $data['loan_value_at_maturity'] = $loan->loan_duration * $loan->loan_payment_amt;

    //Get currently paid amount.
    $payments =  $loan->repayments;

    if ($payments){
        foreach ($payments as $payment){
            $data['paid_amount'] += $payment->amount;
        }
    }

    $data['loan_balance'] = $data['loan_value_at_maturity'] - $data['paid_amount'];

    return $data;

}