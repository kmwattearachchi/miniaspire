<?php

namespace App\Modules\Loan\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Loan\Contracts\LoanRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class LoanController
 * @package App\Modules\Loan\Http\Controllers
 */
class LoanPaymentDetailsController extends Controller
{

    /**
     * Loan repository interface variable.
     * Use to access the loan repository.
     *
     * @var LoanRepositoryInterface
     */
    protected $loanRepo;

    /**
     * LoanController constructor.
     * @param LoanRepositoryInterface $loanRepo
     */
    public function __construct(LoanRepositoryInterface $loanRepo)
    {
        $this->loanRepo = $loanRepo;
    }

    /**
     * Create new loan payment
     *
     * @param Request $request
     * @param bool $loan_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeNewPayment(Request $request, $loan_id = false)
    {
        if ($loan_id){
            $loan = $this->loanRepo->find($loan_id);

            if($loan){

                $validations = $this->_validateFormData($request,$loan_id);

                if($validations){
                    return response()->json(['success'=> false, 'errors' => $validations]);
                }else{
                    $status = $this->loanRepo->updateRepayment(request()->all(),$loan_id);
                    return response()->json(['success'=> true, 'status' => ($status)? 'updated' : 'failed' ]);
                }

            }else{
                return response()->json(['success'=> false,'error' =>'Loan not found!']);
            }

        }else{
            return response()->json(['success'=> false, 'errors' => 'Please provide the loan id']);
        }
    }

    /**
     * Return loan information, repayments.
     *
     * @param bool $loan_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function loanPaymentHistory($loan_id = false)
    {
        if ($loan_id){
            $loan = $this->loanRepo->find($loan_id);

            if($loan){
                return response()->json(['success'=> true,'loan'=>$loan, 'loan_payment_balance' =>getLoanPaymentBalance($loan_id),'repayments'=>$loan->repayments]);
            }else{
                return response()->json(['success'=> false,'error' =>'Loan not found!']);
            }
        }else{
            return response()->json(['success'=> false, 'errors' => 'Please provide the loan id']);
        }
    }

    /**
     * Validate the post data
     * If fails, returns the error messages.
     *
     * @param $request
     * @param $loan_id
     * @return array
     */
    private function _validateFormData($request, $loan_id = false)
    {
        $validation_rules = [
            'amount' => ['bail','required','min:0.1','numeric','regex:/^[0-9]+(\.[0-9][0-9]?)?$/','check_loan_status:'.$loan_id.','.$request->get('amount')],
        ];

        $validator = Validator::make($request->all(), $validation_rules,['required'=>"The :attribute is required."]);
        if ($validator->fails()) {
            return  ['validations'=>$validator->messages()];
        }
    }

}
