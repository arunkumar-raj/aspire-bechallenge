<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasEvents;

use App\Models\User;
use App\Models\LoanRepayment;

class Loans extends Model
{
    use HasFactory;
    use HasEvents;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'amount',
        'scheduled_terms',
        'loan_status',
        'minimum_due',
        'approved_date'
    ];

    /**** Get User data based on loan ****/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**** Get Loan repayment schedule based on loan ****/
    public function schedules()
    {
        return $this->hasMany(LoanRepayment::class,'loan_id');
    }
}

