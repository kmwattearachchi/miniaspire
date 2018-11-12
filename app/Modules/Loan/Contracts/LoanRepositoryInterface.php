<?php
namespace App\Modules\Loan\Contracts;

use App\Contracts\MainRepositoryInterface;

/**
 * Interface LoanRepositoryInterface
 * @package App\Modules\Loan\Contracts
 */
interface LoanRepositoryInterface extends MainRepositoryInterface
{
    /**
     * Update loan payment amount.
     *
     * @param $id
     * @return mixed
     */
    public function updateLoanRepaymentInstallment($id);

    /**
     * Update the paid amount to a loan.
     *
     * @param bool $data
     * @param bool $loan_id
     * @return mixed
     */
    public function updateRepayment($data = false, $loan_id = false);
}