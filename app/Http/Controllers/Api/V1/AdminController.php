<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;
use Exception;

class AdminController extends ApiController
{

    /********** Login Admin user **************/
    public function login(Request $request){
        try {
            //Validate the request 
            $validator = Validator::make($request->all(), 
            [
                'email'    => 'required|email',
                'password' => 'required'
            ]);

            if($validator->fails()){
                return $this->returnError(__('api.validation_error'), $validator->errors());
            }
        
            //Login user using given credentials
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
                'is_admin' => 1
            ];
            if(Auth::attempt($credentials)){
                return $this->returnResponse(Response::HTTP_OK, __('api.admin_login_success'));    
            }else{
                return $this->returnError(__('api.credentials_mismatch'),  [], 401);
            }
        }
        catch(Exception $e){
            Log::error($e);
        }
    }

    /********** Register Admin User **************/
    public function store(Request $request)
    {
        try{

            //Validate the request 
            $validator = Validator::make($request->all(), 
            [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6'],
            ]);
            
            if($validator->fails()){
                 return $this->returnError(__('api.validation_error'), $validator->errors());
            }

            //Create the user after validation passed
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'is_admin' => 1,
                'password' => Hash::make($request->password)
            ]);

            //Create Response
            $response = [
                "status" => Response::HTTP_OK
            ];

            return $this->returnResponse($response, __('api.user_register_success'));
            
        }
        catch(Exception $e){
            Log::error($e);
        }
    }
}
