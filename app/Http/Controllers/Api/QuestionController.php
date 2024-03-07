<?php
namespace App\Http\Controllers\Api;
use App\Models\Game;
use App\Models\Player;
use App\Models\GameTeam;
use App\Traits\ApiFunctions;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\TeamResource;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\GameSlugResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TeamPlayerResource;

class QuestionController extends Controller
{
    use ApiFunctions;
    ///////
}
