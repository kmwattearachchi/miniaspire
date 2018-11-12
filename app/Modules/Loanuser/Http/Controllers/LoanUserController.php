<?php

namespace App\Modules\Loanuser\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Loanuser\Contracts\LoanUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class LoanUserController
 * @package App\Modules\Loanuser\Http\Controllers
 */
class LoanUserController extends Controller
{

    /**
     * Loan User repository interface variable.
     * Use to access the loan user repository.
     *
     * @var LoanUserRepositoryInterface
     */
    protected $loanUserRepo;

    /**
     * LoanUserController constructor.
     * @param LoanUserRepositoryInterface $loanUserRepo
     */
    public function __construct(LoanUserRepositoryInterface $loanUserRepo)
    {
        $this->loanUserRepo = $loanUserRepo;
    }

    /**
     * Get all loan users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoanUsers()
    {
        $loan_users = $this->loanUserRepo->all();
        return response()->json(['success'=>true,'loan_users' =>$loan_users]);
    }

    /**
     * Get loan user by user id.
     *
     * @param bool $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLoanUser($id = false)
    {
        if ($id){
            $loan_user = $this->loanUserRepo->find($id);

            if($loan_user){
                return response()->json(['success'=> true,'loan_user' =>$loan_user,'loans'=>$loan_user->loans]);
            }else{
                return response()->json(['success'=> false,'error' =>'User not found!']);
            }

        }else{
            return response()->json(['success'=> false, 'errors' => 'Please provide the loan user id']);
        }
    }

    /**
     * Create new loan user.
     * Returns newly created user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createLoanUser(Request $request)
    {
        if ($request->all()) {

            $validations = $this->_validateFormData($request);

            if($validations){
                return response()->json(['success'=> false, 'errors' => $validations]);
            }else{
                $user = $this->loanUserRepo->create(request()->all());
                if($user){
                    return response()->json(['success'=> true, 'user' => $user]);
                }else{
                    return response()->json(['success'=> false, 'error' => 'Error while creating loan user.']);
                }
            }

        } else {
            return response()->json(['success'=> false, 'msg' => env('DATA_MISSING_MESSAGE')]);
        }
    }

    /**
     * Update loan user details
     * Returns update success/failed
     *
     * @param Request $request
     * @param bool $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLoanUser(Request $request, $id = false)
    {
        if ($id && $request->all()) {

            $validations = $this->_validateFormData($request);

            if($validations){
                return response()->json(['success'=> false, 'errors' => $validations]);
            }else{
                $status = $this->loanUserRepo->update(request()->all(),$id);
                return response()->json(['success'=> true, 'status' => ($status)? 'updated' : 'failed' ]);
            }

        } elseif ($id == false) {
            return response()->json(['success'=> false, 'errors' => 'Please provide the loan user id']);
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
            'first_name' => ['required'],
        ];

        $validator = Validator::make($request->all(), $validation_rules, ['required'=>"The :attribute is required."]);
        if ($validator->fails()) {
            return  ['validations'=>$validator->messages()];
        }
    }


}
