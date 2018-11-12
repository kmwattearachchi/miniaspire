<?php

namespace App\Modules\Loan\Repositories;

use App\Loan;
use App\LoanRepayment;
use App\Repositories\MainRepository;
use App\Modules\Loan\Contracts\LoanRepositoryInterface;
use Illuminate\Contracts\Container\Container as App;


class LoanRepository extends MainRepository implements LoanRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Loan';
    }

    /**
     * Update loan payment amount.
     * Calculate monthly pay.
     *
     * @param $id
     * @return Loan|Loan[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function updateLoanRepaymentInstallment($id)
    {
        $loan = Loan::find($id);
        $capital = $loan->loan_amount;
        $interest = $loan->loan_interest_rate;
        $months = $loan->loan_duration;
        $interest = $interest / 100;

        $payment = $interest / 12 * pow(1 + $interest / 12, $months) / (pow(1 + $interest / 12, $months) - 1) * $capital;

        $loan->loan_payment_amt = round($payment,2);
        $loan->save();
        return $loan;
    }

    /**
     * Update the paid amount to a loan.
     *
     * @param bool $data
     * @param bool $loan_id
     * @return mixed
     */
    public function updateRepayment($data = false,$loan_id = false)
    {
        $loan = Loan::find($loan_id);
        $loan->repayments()->create($data);
        return true;
    }
}