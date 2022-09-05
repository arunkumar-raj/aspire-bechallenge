<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Models\LoanRepayment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;
use Exception;

class LoanRepayController extends ApiController
{
    /********** Display all Payment schedules for the User ie customer **************/
    public function index()
    {
        //
    }


    /********** Display Single Payment Schedule **************/
    public function show($id)
    {
        //
    }

    /********** Update Repayment for particular schedule **************/
    public function update(Request $request, $id)
    {
        //
    }

    
}
