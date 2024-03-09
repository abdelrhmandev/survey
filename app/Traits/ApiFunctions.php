<?php
namespace App\Traits;
use JWTAuth;
use JWTFactory;
use App\Models\Player;
use LaravelLocalization;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
/**
 * Trait UploadAble
 * @package App\Traits
 */
trait ApiFunctions
{




    function checkJoinTeam($game_team_id,$game_id) {

        return $query = Player::where(['game_id'=>$game_id,'game_team_id'=>$game_team_id])->count();

    }


    function validateJwtToken($token) {
        // split the jwt
       
       
        // $tokenParts   = explode(".", $token);  
        // $tokenHeader  = base64_decode($tokenParts[0]);
        // $tokenPayload = base64_decode($tokenParts[1]);
        // $jwtHeader    = json_decode($tokenHeader);
        // $jwtPayload   = json_decode($tokenPayload);
        // $game_id      = $jwtPayload->game_id;        
        // $expDate = $jwtPayload->exp;

    }

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
