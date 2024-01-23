<?php
namespace App\Http\Controllers\backend;
use App\Http\Requests\backend\GameRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameTeam;
use App\Models\Type;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Traits\Functions;
use App\Traits\UploadAble;
use DataTables;
class QuestionController extends Controller
{
    use UploadAble, Functions;
    public function __construct()
    {
        $this->ROUTE_PREFIX = 'admin.questions';
        $this->TRANS = 'question';
        $this->UPLOADFOLDER = 'questions';
    }
    public function create($GameId = null)
    {
        if (view()->exists('backend.questions.create')) {
            $compact = [
                'GameId'       => $GameId ?? '',
                'games'         => Game::select('id', 'title')->get(),
                'trans'         => $this->TRANS,
                'listingRoute'  => route($this->ROUTE_PREFIX . '.index'),
                'storeRoute'    => route($this->ROUTE_PREFIX . '.store'),
            ];
            return view('backend.questions.create', $compact);
        }
    }
}
