<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasEvents;

use App\Models\Loans;
class LoanRepayment extends Model
{
    use HasFactory;
    use HasEvents;
    
    public $timestamps = false;

    protected $fillable = [
        'loan_id',
        'due_date',
        'due_amount',
        'paid_date',
        'paid_amount',
        'status'
    ];

    /**** Get Loan data based on Repayment schedule ****/
    public function loan()
    {
        return $this->belongsTo(Loans::class);
    }
}
