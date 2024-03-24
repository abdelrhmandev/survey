<?php
namespace App\Http\Controllers\Backend;
use DataTables;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Answer;
use App\Models\Question;
use App\Models\QuestionCorrectAnswer;
use App\Traits\Functions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\backend\QuestionRequest;

class QuestionController extends Controller
{
    use Functions;
    public function __construct()
    {
        $this->ROUTE_PREFIX = 'admin.questions';
        $this->TRANS = 'question';
        $this->UPLOADFOLDER = 'questions';
    }

    public function index(Request $request,$b_id=null)
    {
        (isset($request->brand_id)) ? $brand_id = $request->brand_id : $brand_id = $b_id;

        // echo ($GID);
        $model = Question::where('brand_id',$brand_id)->with(['brand', 'answers', 'correctAnswer']);
        if ($request->ajax()) {
            return Datatables::of($model)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    $QuestionAnswers = '';
                    if (count($row->answers)) {
                        foreach ($row->answers as $value) {
                            if ($value->id == $row->correctAnswer->correct_answer_id) {
                                $class = 'success';
                            } else {
                                $class = 'primary';
                            }
                            $QuestionAnswers .= "<div class=\"badge py-3 px-4 fs-7 badge-light-" . $class . " mt-1\">&nbsp;<span class=\"text-" . $class . "\">" . $value->title . '</span></div><br> ';
                        }
                        $QuestionAnswers = "<span class =\"text-muted\">Answers</span><br> " . substr($QuestionAnswers, 0, -2);
                    }
                    return '<a href=' . route($this->ROUTE_PREFIX . '.edit', $row->id) . " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" . $row->id . "=\"item\">" . $row->title . '</a><br>' . $QuestionAnswers;
                })


               
                ->editColumn('time', function ($row) {
                    return "<span class=\"text-info fw-bolder fs-3\">" . $row->time . '</span>';
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                })
                ->editColumn('actions', function ($row) {
                    return $this->dataTableEditRecordAction($row, $this->ROUTE_PREFIX);
                })
                ->rawColumns(['title', 'time', 'actions', 'created_at', 'created_at.display'])
                ->make(true);
        }
        if (view()->exists('backend.questions.index')) {
            $compact = [
                'trans' => $this->TRANS,
                'brand_id' => $brand_id ?? 0,
                'counter'=>$model->count(),
                'brands' => Brand::select('id', 'title')->withCount('questions')->get(),
                'createRoute' => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute' => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute' => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute' => route($this->ROUTE_PREFIX . '.index'),
            ];
            return view('backend.questions.index', $compact);
        }
    }

    public function create($BrandId = null)
    {
        if (view()->exists('backend.questions.create')) {
            $compact = [
                'BrandId' => $BrandId ?? '',
                'brands' => Brand::select('id', 'title')->get(),
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
                'brands' => Brand::select('id', 'title')->get(),
                'updateRoute' => route($this->ROUTE_PREFIX . '.update', $question->id),
                'row' => $question,
                'destroyRoute' => route($this->ROUTE_PREFIX . '.destroy', $question->id),
                'redirect_after_destroy' => route($this->ROUTE_PREFIX . '.index'),
                'trans' => $this->TRANS,
            ];
            return view('backend.questions.edit', $compact);
        }
    }

    public function store(QuestionRequest $request)
    {
        $data = [
            'title' => $request->title,
            'brand_id' => $request->brand_id,
            'score' => $request->score,
            'time' => $request->time,
        ];
        $query = Question::create($data);
        $answerArr = [];
        foreach ($request->answers as $k => $answer) {
            $answerArr[$k]['title'] = $answer;
            $answerArr[$k]['question_id'] = $query->id;
        }
        $answer = Answer::insert($answerArr);
        $arr = [
            'QT' => $query->title,
            'Qid' => $query->id,
            'action' => route('admin.saveQCAnswer'),
            'answers' => $query->answers()->get(),
            'msg' => __($this->TRANS . '.' . 'storeMessageSuccess'),
            'status' => true,
        ];

        return response()->json($arr);
    }

    public function saveQCAnswer(Request $request)
    {
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

    public function update(QuestionRequest $request, Question $question)
    {
        $validated = $request->validated();

        $validated['brand_id'] = $request->brand_id;
        $validated['title'] = $request->title;
        $validated['score'] = $request->score;
        $validated['time'] = $request->time;

        $cases = [];
        $ids = [];
        $params = [];
        foreach ($request->answers as $id => $value) {
            $cases[] = "WHEN {$id} then ?";
            $params[] = $value;
            $ids[] = $id;
        }
        $ids = implode(',', $ids);
        $cases = implode(' ', $cases);
        \DB::update("UPDATE `answers` SET `title` = CASE `id` {$cases} END  WHERE `id` in ({$ids})", $params);
        QuestionCorrectAnswer::updateOrCreate(['question_id' => $question->id], ['correct_answer_id' => $request->correct_answer_check]);
        if (Question::findOrFail($question->id)->update($validated)) {
            $arr = ['msg' => __($this->TRANS . '.updateMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
}
