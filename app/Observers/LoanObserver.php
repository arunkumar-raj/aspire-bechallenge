<?php

namespace App\Observers;
use App\Models\Loans;
use Illuminate\Support\Carbon;

class LoanObserver
{
    //Observer on Loan Approved 
    public function Updated(Loans $loan)
    {
        //Create the Loan Repayment schedule on loan approval
        if($loan->loan_status == 'APPROVED'){
            $due_amount = round($loan->amount/$loan->scheduled_terms,2);
            $scheduled_terms = $loan->scheduled_terms;
            $approved_date = $loan->approved_date;
            $schedules = [];
            while($scheduled_terms >= 1){
                $due_date = isset($due_date)?Carbon::parse($due_date)->addDays(7):Carbon::parse($approved_date)->addDays(7);
                $schedules[] = [
                    'due_date' => $due_date,
                    'due_amount' => $due_amount
                ];
                $scheduled_terms --;
            }
            $loan->schedules()->createMany($schedules);
        }
    }
}
