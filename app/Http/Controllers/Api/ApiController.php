<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Log;
use Exception;

class ApiController extends Controller
{
    /********** Return API Success Response **************/
    public function returnResponse($data, $message, $code = 200){
        try{
            $response = [
                'success' => true,
                'message' => $message
            ];

            if(!empty($data)){
                $response['data'] = $data;
            }
            return response()->json($response, $code);
        }
        catch(Exception $e){
            Log::error($e);
        }
    }

    /********** Return API Error Response **************/
    public function returnError($error, $errMessages = [], $code = 310){
        try{
            $response = [
                'message' => $error,
            ];

            if(!empty($errMessages)){
                $response['data'] = $errMessages;
            }
            return response()->json($response, $code);
        }
        catch(Exception $e){
            Log::error($e);
        }
    }

    /********** Logout Any user ie customer **************/
    public function logout(){
        try {
            Session::flush();
            Auth::logout();
            return $this->returnResponse('', __('api.user_logout_success')); 
        }
        catch(Exception $e){
            Log::error($e);
        }
    }
}
