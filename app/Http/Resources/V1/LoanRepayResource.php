<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanRepayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'repaymentid'=>$this->id,
            'loannumber' =>$this->loan_id,
            'duedate' =>  $this->due_date,
            'dueamount' => $this->due_amount,
            'paidamount' => ($this->paid_amount != null)?$this->paid_amount:'Not paid',
            'paymentstatus' => $this->status
        ];
    }
}
