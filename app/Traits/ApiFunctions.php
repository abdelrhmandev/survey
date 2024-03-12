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
    function checkJoinTeam($game_team_id, $game_id)
    {
        return $query = Player::where(['game_id' => $game_id, 'game_team_id' => $game_team_id])->count();
    }

    public function bearerToken(){
       $header = $this->header('Authorization', '');
       if (Str::startsWith($header, 'Bearer ')) {
           return Str::substr($header, 7);
       }
  }
    public function returnError($errNum, $msg)
    {
        return response()->json([
            'status' => false,
            'code'   => $errNum,
            'msg'    => $msg,
        ]);
    }

    public function ValidToken($token, $expire_date)
    {
        return response()->json([
            'status' => false,
            'code'   => '500',
            'msg'    => 'Token Expired',
        ]);
    }

    public function decodeToken($token,$key)
    {
        $tokenParts   = explode(".", $token);  
        $tokenHeader  = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader    = json_decode($tokenHeader);
        $jwtPayload   = json_decode($tokenPayload);
        return $jwtPayload->{$key};
    }
    public function returnQData($key, $value, $response_code, $msg = '')
    {
        return response()->json([
            'status'          => true,
            'code'            => $response_code ?? 'S000',
            'msg'             => $msg,
            'question_status' => $value->status,
            $key              => $value,
        ]);
    }
    public function returnNoQData($value)
    {
        return response()->json([
            'code'              => '404',
            'question_status'  => 'pending',
        ]);
    }
    public function returnData($key, $value, $response_code, $msg = '')
    {
        return response()->json([
            'status'    => true,
            'code'      => $response_code ?? 'S000',
            'msg'       => $msg,
            $key        => $value,
        ]);
    }
    public function returnPlayerSubmitData($key, $value, $response_code, $msg = '',$remaining_questions)
    {
        return response()->json([
            'status'              => true,
            'code'                => $response_code ?? 'S000',
            'msg'                 => $msg,
            'remaining_questions' =>$remaining_questions,
            $key                  => $value,
        ]);
    }


    

    public function returnMultiData($key, $value, $response_code, $msg = '')
    {
        return response()->json([
            'status'    => true,
            'code'      => $response_code ?? 'S000',
            'msg'       => $msg,
            'counter'   => $value->count(),
            $key        => $value,
        ]);
    }

    public function returnMultiTeamsData($key, $value, $response_code, $msg = '',$has_team)
    {
        return response()->json([
            'status'    => true,
            'code'      => $response_code ?? 'S000',
            'msg'       => $msg,
            'counter'   => $value->count(),
            'has_team'  => $has_team,
            $key        => $value,
        ]);
    }
}
