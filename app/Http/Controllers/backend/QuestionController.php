<?php
namespace App\Http\Controllers\backend;
use DataTables;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionCorrectAnswer;
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
    public function edit(Question $question)
    {
        if (view()->exists('backend.questions.edit')) {
            $compact = [
                'games'                   => Game::select('id', 'title')->get(),
                'updateRoute'             => route($this->ROUTE_PREFIX . '.update', $question->id),
                'row'                     => $question,
                'destroyRoute'            => route($this->ROUTE_PREFIX . '.destroy', $question->id),
                'redirect_after_destroy'  => route($this->ROUTE_PREFIX . '.index'),
                'trans'                   => $this->TRANS,
            ];
            return view('backend.questions.edit', $compact);
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
        $answerArr = [];
        foreach ($request->answers as $k => $answer) {
            $answerArr[$k]['title'] = $answer;
            $answerArr[$k]['question_id'] = $query->id;
        }
        $answer = Answer::insert($answerArr);
        $arr = [
            'QT'      => $query->title,
            'Qid'     => $query->id,
            'action'  => route('admin.saveQCAnswer'),
            'answers' => $query->answers()->get(),
            'msg'     => __($this->TRANS . '.' . 'storeMessageSuccess'),
            'status'  => true,
        ];

        return response()->json($arr);
    }

    public function saveQCAnswer(Request $request){
        if (intval($request->answer_id) && intval($request->question_id)) {
            $answer = QuestionCorrectAnswer::insert(['question_id' => $request->question_id, 'correct_answer_id' => $request->answer_id]);
            $arr = [
                'msg' => 'Thanks You have Add The Correct Question Answer',
                'status' => true,
            ];
        } else {
            $arr = [
                'msg' => 'You need to choose Correct Question Answer!',
                'editQRoute' => route('admin.questions.edit', $request->question_id),
                'status' => false,
            ];
        }
        return response()->json($arr);
    }


    public function update(Request $request, Question $question){
        // $validated = $request->validated();
        $AnswerArr = [];
        foreach($request->answers as $k =>$v){
            $AnswerArr[$k]['title'] = $v;
        }

        echo '<pre>';
        print_r($AnswerArr);

        Answer::bulkUpdate($AnswerArr, ['id'], ['value']);
        // Answer::where('question_id',$question->id)->update($AnswerArr);

    }



}
