<?php
namespace App\Traits;
use Illuminate\Support\Str;
use LaravelLocalization;
use Illuminate\Http\Request;
/**
 * Trait UploadAble
 * @package App\Traits
 */
trait ApiFunctions
{
    public function returnError($errNum, $msg){
        return response()->json([
            'status' => false,
            'code'  => $errNum,
            'msg'    => $msg
        ]);
    }

    public function ValidToken($token, $expire_date){
        return response()->json([
            'status' => false,
            'code'  => '500',
            'msg'    => 'Token Expired'
        ]);
    }


    public function returnData($key, $value,$response_code, $msg = ""){
        return response()->json([
            'status' => true,
            'code' => $response_code ?? "S000",
            'msg' => $msg,
            $key => $value
        ]);
    }
    public function returnMultiData($key, $value,$response_code, $msg = ""){
        return response()->json([
            'status' => true,
            'code' => $response_code ?? "S000",
            'msg' => $msg,
            'counter' => ($value->count()),
            $key => $value
        ]);
    }

   


}
