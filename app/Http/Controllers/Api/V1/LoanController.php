<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Models\Loans;
use App\Http\Resources\V1\LoanResource;
use App\Http\Resources\V1\LoanCollection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;
use Exception;

class LoanController extends ApiController
{
    /********** Display all Loans based on User Role **************/
    public function index()
    {
        try {
            if (Auth::check()) {
                // Get logged in user details
                $user_id = Auth::user()->id;
                $is_admin = Auth::user()->is_admin;

                //Show all lists for admin
                if($is_admin){
                    $loans = Loans::all()->sortByDesc("id");
                    return new LoanCollection($loans);
                }else{ 
                //Show particualar loan for customer
                    $user_loans = Loans::where('user_id',$user_id)->get();
                    return new LoanCollection($user_loans);
                }

            }else{
                return $this->returnError(__('api.please_login'),  [], 401);
            }
        }catch(Exception $e){
            Log::error($e);
        }
    }

    /********** Create Loan Request for Customer only **************/
    public function store(Request $request)
    {
        try {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
                $is_admin = Auth::user()->is_admin;

                if(!$is_admin){
                    $user_loans = Loans::where('user_id',$user_id)->where('loan_status', '!=' , 'PAID')->get();
                    if(!$user_loans->isEmpty()){
                        return $this->returnError(__('api.already_applied'));
                    }
                    //Validate the request 
                    $validator = Validator::make($request->all(), 
                    [
                        'amount'     => ['required', 'numeric', 'max:50000'],
                        'term'    => ['required', 'numeric'],
                    ]);
                    
                    if($validator->fails()){
                        return $this->returnError(__('api.validation_error'), $validator->errors());
                    }

                    //Create the Loan for customer
                    Loans::create([
                        'user_id' => $user_id,
                        'amount' => $request->amount,
                        'scheduled_terms' => $request->term
                    ]);

                    //Create Response
                    $response = [
                        "status" => Response::HTTP_OK
                    ];

                    return $this->returnResponse($response, __('api.loan_register_success'));
                }
                return $this->returnError(__('api.admin_cant_apply'),  [], 401);

            }else{
                return $this->returnError(__('api.please_login'),  [], 401);
            }
        }catch(Exception $e){
            Log::error($e);
        }
    }

    /********** View Single Loan Admin Only **************/
    public function show($id)
    {
        try {
            if (Auth::check()) {
                $is_admin = Auth::user()->is_admin;
                if($is_admin){
                    $single_loan = Loans::where('id',$id)->first();
                    return new LoanResource($single_loan);
                }
                return $this->returnError(__('api.only_admin'),  [], 401);
            }else{
                return $this->returnError(__('api.please_login'),  [], 401);
            }
        }catch(Exception $e){
            Log::error($e);
        }
    }

    /********** Approve Loan request Admin Only **************/
    public function update(Request $request, $id)
    {
        try {
            if (Auth::check()) {
                $is_admin = Auth::user()->is_admin;
                if($is_admin){
                    $loan_update = Loans::where('id',$id)->first();
                    if($loan_update->count()){
                        $minimum_amt = round($loan_update->amount/$loan_update->scheduled_terms,2);
                        $loan_update->minimum_due = $minimum_amt;
                        $loan_update->loan_status = "APPROVED";
                        $loan_update->approved_date = date("Y-m-d");
                        $loan_update->update();
                        return new LoanResource($loan_update);
                    }
                }
                return $this->returnError(__('api.only_admin'),  [], 401);
            }else{
                return $this->returnError(__('api.please_login'),  [], 401);
            }
        }catch(Exception $e){
            Log::error($e);
        }
    }

    /********** Delete Loan request Admin Only **************/
    public function destroy($id)
    {
        try {
            if (Auth::check()) {
                $is_admin = Auth::user()->is_admin;
                if($is_admin){
                    $single_loan = Loans::where('id',$id)->first();
                    $single_loan->delete();
                    $response = [
                        "status" => Response::HTTP_OK
                    ];
                    return $this->returnResponse($response, __('api.loan_delete'));
                }
                return $this->returnError(__('api.only_admin'),  [], 401);
            }else{
                return $this->returnError(__('api.please_login'),  [], 401);
            }
        }catch(Exception $e){
            Log::error($e);
        }
    }
}
