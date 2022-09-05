<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /********** Display data in nice format **************/
    public function toArray($request)
    {
        $get_user = $request->user();
        return [
            'loanid'=>$this->id,
            'username' => $get_user->name,
            'useremail' => $get_user->email,
            'loanamount' => $this->amount,
            'repayterms' => $this->scheduled_terms,
            'loanstatus' => $this->loan_status
        ];
    }
}
