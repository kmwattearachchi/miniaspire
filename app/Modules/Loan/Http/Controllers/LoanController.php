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
class LoanController extends Controller
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
     * Get all loans
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoans()
    {
        $loans = $this->loanRepo->all();
        return response()->json(['success'=>true,'loans' =>$loans]);
    }

    /**
     * Get loan details by loan id
     *
     * @param bool $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoan($id = false)
    {
        if ($id){
            $loan = $this->loanRepo->find($id);

            if($loan){
                return response()->json(['success'=> true,'loan' =>$loan]);
            }else{
                return response()->json(['success'=> false,'error' =>'Loan not found!']);
            }

        }else{
            return response()->json(['success'=> false, 'errors' => 'Please provide the loan id']);
        }
    }

    /**
     * Create new loan.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewLoan(Request $request)
    {
        if ($request->all()) {

            $validations = $this->_validateFormData($request);

            if($validations){
                return response()->json(['success'=> false, 'errors' => $validations]);
            }else{
                $loan = $this->loanRepo->create(request()->all());
                if($loan){
                    $loan = $this->loanRepo->updateLoanRepaymentInstallment($loan->id);
                    return response()->json(['success'=> true, 'loan' => $loan]);
                }else{
                    return response()->json(['success'=> false, 'error' => 'Error while creating loan.']);
                }
            }

        } else {
            return response()->json(['success'=> false, 'msg' => env('DATA_MISSING_MESSAGE')]);
        }
    }

    /**
     * Update loan details.
     *
     * @param Request $request
     * @param bool $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLoanDetails(Request $request, $id = false)
    {
        if ($id && $request->all()) {

            $loan = $this->loanRepo->find($id);
            if($loan){
                $validations = $this->_validateFormData($request);

                if($validations){
                    return response()->json(['success'=> false, 'errors' => $validations]);
                }else{
                    $status = $this->loanRepo->update(request()->all(),$id);
                    $this->loanRepo->updateLoanRepaymentInstallment($id);
                    return response()->json(['success'=> true, 'status' => ($status)? 'updated' : 'failed' ]);
                }
            }else{
                return response()->json(['success'=> false, 'error' => 'Loan not found.']);
            }

        } elseif ($id == false) {
            return response()->json(['success'=> false, 'errors' => 'Please provide the loan id']);
        } else {
            return response()->json(['success'=> false, 'msg' => env('DATA_MISSING_MESSAGE')]);
        }
    }

    /**
     * Validate the post data
     * If fails, returns the error messages.
     *
     * @param $request
     * @return array
     */
    private function _validateFormData($request)
    {
        $validation_rules = [
            'loan_user' => ['bail','required','exists:loan_users,id'],
            'loan_amount' => ['bail','required','min:1','numeric','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'loan_duration' => ['bail','required','integer'],
            'loan_interest_rate' => ['bail','required','min:0.1','numeric','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'loan_repayment_frequency' => ['bail','required','in:'.REPAYMENT_TYPE_MONTHLY.','.REPAYMENT_TYPE_WEEKLY.','.REPAYMENT_TYPE_DAILY.','.REPAYMENT_TYPE_ANNUALLY],
            'loan_arrangement_fee' => ['bail','required','min:0','numeric','regex:/^[0-9]+(\.[0-9][0-9]?)?$/']
        ];

        $validator = Validator::make($request->all(), $validation_rules,['required'=>"The :attribute is required."]);
        if ($validator->fails()) {
            return  ['validations'=>$validator->messages()];
        }
    }

}
