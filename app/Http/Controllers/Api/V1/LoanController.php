<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Models\Loans;

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
        //
    }

    /********** Create Loan Request for Customer only **************/
    public function store(Request $request)
    {
        //
    }

    /********** View Single Loan Admin Only **************/
    public function show($id)
    {
        //
    }

    /********** Approve Loan request Admin Only **************/
    public function update(Request $request, $id)
    {
        //
    }

    /********** Delete Loan request Admin Only **************/
    public function destroy($id)
    {
        //
    }
}
