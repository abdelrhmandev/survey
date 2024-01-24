<?php
namespace App\Http\Controllers\backend;
use DataTables;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Choice;
use App\Models\Question;
use App\Traits\Functions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\backend\GameRequest;

class QuestionController extends Controller
{
    use Functions;
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
                'GameId' => $GameId ?? '',
                'games' => Game::select('id', 'title')->get(),
                'trans' => $this->TRANS,
                'listingRoute' => route($this->ROUTE_PREFIX . '.index'),
                'storeRoute' => route($this->ROUTE_PREFIX . '.store'),
            ];
            return view('backend.questions.create', $compact);
        }
    }

    public function store(Request $request)
    {
        $data = [
            'title' => $request->title,
            'game_id' => $request->game_id,
            'score' => $request->score,
            'time' => $request->time,
            'difficulty' => $request->difficulty,
        ];
        $query = Question::create($data);

        $choiceArr = [];
        foreach ($request->choices as $k => $choice) {
            $choiceArr[$k]['title'] = $choice;
            $choiceArr[$k]['question_id'] = $query->id;
        }

        $choice = Choice::insert($choiceArr);

        $arr = [
            'QT' => $query->title,
            'Qid' => $query->id,
            'action' => route('admin.saveQCHOICE'),
            'choices' => $query->choices()->get(),
            'msg' => __($this->TRANS . '.' . 'storeMessageSuccess'),
            'status' => true,
        ];

        return response()->json($arr);
    }

    public function saveQCHOICE(Request $request)
    {
        if (intval($request->choice_id) && intval($request->question_id)) {
            $choice = QuestionCorrectAnswer::insert(['question_id' => $request->question_id, 'correct_choice_id' => $request->question_id]);
            $arr = [
                'msg' => 'Thanks You have Add The Correct Question Answer',
                'status' => true,
            ];
        } else {
            $arr = [
                'msg' => 'You need to choose Correct Question Answer!',
                'editQRoute' => route('admin.questions.edit', $query->id),
                'status' => false,
            ];
        }

        return response()->json($arr);
    }
}
