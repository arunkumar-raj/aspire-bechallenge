<?php

namespace App\Observers;
use App\Models\LoanRepayment;
use App\Models\Loans;

class LoanRepayObserver
{
   //Observer on Loan Repayment 
   public function Updated(LoanRepayment $repay)
   {
       //Calculate the amout paid and close the loan
       $get_loan_data = Loans::find($repay->loan_id);
       if($get_loan_data->loan_status == 'APPROVED'){
           $loan_amount = $get_loan_data->amount;

           $sum_paid_amt= round(LoanRepayment::where('loan_id',$repay->loan_id)->sum('paid_amount'));

           //Close loan based on payment
           if($loan_amount <= $repay->paid_amount || $loan_amount <= $sum_paid_amt){
               $get_loan_data->loan_status = "PAID";
               $get_loan_data->update();
           }
       }
   }
}
