<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Models\Loans;
use App\Models\LoanRepayment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\V1\LoanRepayResource;
use App\Http\Resources\V1\LoanRepayCollection;

use Illuminate\Support\Facades\Log;
use Exception;

class LoanRepayController extends ApiController
{
    /********** Display all Payment schedules for the User ie customer **************/
    public function index()
    {
        try {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
                $user_loans = Loans::where('user_id',$user_id)->where('loan_status', 'APPROVED')->first();
                if(! empty($user_loans) && $user_loans->count()){
                    $schedules = LoanRepayment::all()->sortBy("id");
                    return new LoanRepayCollection($schedules);
                }else{
                    return $this->returnError(__('api.no_schedules'),  [], 401);
                }
            }else{
                return $this->returnError(__('api.please_login'),  [], 401);
            }
        }catch(Exception $e){
            Log::error($e);
        }
    }


    /********** Display Single Payment Schedule **************/
    public function show($id)
    {
        try {
            if (Auth::check()) {
                $single_schedule = LoanRepayment::where('id',$id)->first();
                return new LoanRepayResource($single_schedule);
            }else{
                return $this->returnError(__('api.please_login'),  [], 401);
            }
        }catch(Exception $e){
            Log::error($e);
        }
    }

    /********** Update Repayment for particular schedule **************/
    public function update(Request $request, $id)
    {
        try {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
                $user_loans = Loans::where('user_id',$user_id)->where('loan_status', 'APPROVED')->first();
                if(! empty($user_loans) && $user_loans->count()){
                    $validator = Validator::make($request->all(), 
                    [
                        'amount' => ['required', 'numeric', function ($attribute, $value, $fail) use($user_loans) {
                            if ($user_loans->minimum_due > $value) {
                                return $fail(__("Repayment amount is $user_loans->minimum_due"));
                            }
                        }]
                    ]);

                    if($validator->fails()){
                        return $this->returnError(__('api.validation_error'), $validator->errors());
                    }

                    //Skip if paid 
                    $schedule_update = LoanRepayment::where('id',$id)->where('status', 'PENDING')->first();
                    if(! empty($schedule_update) && $schedule_update->count()){
                        $schedule_update->paid_amount = $request->amount;
                        $schedule_update->paid_date = date("Y-m-d");
                        $schedule_update->status = "PAID";
                        $schedule_update->update();
                        return new LoanRepayResource($schedule_update);
                    }else{
                        return $this->returnError(__('api.already_paid'),  [], 401);
                    }

                }else{
                    return $this->returnError(__('api.loan_closed'),  [], 401);
                }
            }else{
                return $this->returnError(__('api.please_login'),  [], 401);
            }
        }catch(Exception $e){
            Log::error($e);
        }
    }

    
}
