<?php
namespace App\Http\Controllers\backend;
use App\Http\Requests\backend\GameRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Question;
use App\Models\Game;
use App\Models\GameTeam;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Traits\Functions;
use App\Traits\UploadAble;
use DataTables;
class GameController extends Controller
{
    use UploadAble, Functions;
    public function __construct()
    {
        $this->ROUTE_PREFIX = 'admin.games';
        $this->TRANS = 'game';
        $this->UPLOADFOLDER = 'games';
    }

    public function index(Request $request)
    {
        $model = Game::select('*')
            ->with(['type'])
            ->withCount(['questions']);
        if ($request->ajax()) {
            return Datatables::of($model)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    return '<a href=' .
                        route($this->ROUTE_PREFIX . '.edit', $row->id) .
                        " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" .
                        $row->id .
                        "=\"item\">" .
                        $row->title .
                        '</a>
                    <p>
                    Attendees
                    ' .
                        "<span class=\"text-success fw-bolder fs-3\">" .
                        $row->attendees .
                        '</span>
                    | Questions
                    ' .
                        "<span class=\"text-primary fw-bolder fs-3\">" .
                        $row->questions_count .
                        '</span>
                    </p>                  
                    ';
                })

                ->editColumn('image', function ($row) {
                    return $this->dataTableGetImage($row, $this->ROUTE_PREFIX . '.edit');
                })
                ->editColumn('event_id', function ($row) {
                    return '<a href=' . route('admin.events.edit', $row->event_id) . " class=\"text-hover-success\"  title=" . $row->event->title . '>' . $row->event->title . '</a>';
                })
                ->editColumn('play_with_team', function ($row) {
                    $playWithTeam =
                        '
                    <p>
                    ' .
                        "<span class=\"badge py-3 px-4 fs-7 badge-light-danger\"><span class=\"text-danger\">No</span></span>" .
                        '
                    </p>';

                    if ($row->play_with_team == '1') {
                        $playWithTeam =
                            '
                    <p>
                    ' .
                            "<span class=\"badge py-3 px-4 fs-7 badge-light-success\"><span class=\"text-success\">Yes</span></span><br>" .
                            '
                    ' .
                            __('game.team_players') .
                            '
                    ' .
                            "<span class=\"text-info fw-bolder fs-3\">" .
                            $row->team_players .
                            '</span>
                    </p>';
                    }

                    return $playWithTeam;
                })

                ->editColumn('type_id', function ($row) {
                    return '<a href=' . route('admin.types.edit', $row->type_id) . " class=\"text-hover-success\"  title=" . $row->type->title . '>' . $row->type->title . '</a>';
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })
                ->editColumn('actions', function ($row) {
                    $addQuestion =
                        '<br/><br/><a href=' .
                        route('admin.Q', $row->id) .
                        " class=\"btn btn-sm btn-light-primary\">
                <i class=\"ki-outline ki-plus-square fs-3\"></i>" .
                        __('question.add') .
                        "</a>
            ";

                    // "<span class=\"text-dark fw-bolder fs-3\">".$row->questions_count."</span>&nbsp;".$addQestion;

                    return $this->dataTableEditRecordAction($row, $this->ROUTE_PREFIX).$addQuestion;
                })
                ->rawColumns(['image', 'title', 'question_id', 'play_with_team', 'type_id', 'actions', 'created_at', 'created_at.display'])
                ->make(true);
        }
        if (view()->exists('backend.games.index')) {
            $compact = [
                'trans' => $this->TRANS,
                'createRoute' => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute' => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute' => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute' => route($this->ROUTE_PREFIX . '.index'),
            ];
            return view('backend.games.index', $compact);
        }
    }
    public function create()
    {
        if (view()->exists('backend.games.create')) {
            $compact = [
                'types' => Type::select('id', 'title')->get(),  
                'brands' => Brand::select('id', 'title')->withCount('questions')->get(),               
                'trans' => $this->TRANS,
                'listingRoute' => route($this->ROUTE_PREFIX . '.index'),
                'storeRoute' => route($this->ROUTE_PREFIX . '.store'),
            ];
            return view('backend.games.create', $compact);
        }
    }
    public function store(GameRequest $request)
    {
        $validated = $request->validated();
        // $validated['image'] = !empty($request->file('image')) ? $this->uploadFile($request->file('image'), $this->UPLOADFOLDER) : null;
        // $validated['slug'] = Str::slug($request->title);


        $EventDateRange = explode(" - ", $request->event_date_range);
 
        $GameArr = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'image' => !empty($validated['image']) ? $this->uploadFile($validated['image'], $this->UPLOADFOLDER) : null,
            'description' => $validated['description'],
            'attendees' => $validated['attendees'], 
            'type_id' => $validated['type_id'],
            'play_with_team' => $validated['play_with_team'] ?? '0',
            'team_players' => $validated['team_players'] ?? NULL,
            'event_title' => $validated['event_title'],
            
            'event_start_date' => $EventDateRange[0],
            'event_end_date' => $EventDateRange[1],
            'event_location' => $validated['event_location'],
        ];
     
        //Draw Game Team Records
        
        $query = Game::create($GameArr);
     
        if ($query) {
            /*if ($request->play_with_team && $request->play_with_team == '1') {
                $TeamRecords = ceil($validated['attendees'] / $validated['team_players']);
                $gameTeamInfo = [];
                for ($i = 1; $i <= $TeamRecords; $i++) {
                    $gameTeamInfo[$i]['game_id'] = $query->id;
                    $gameTeamInfo[$i]['event_id'] = $validated['event_id'];
                    $gameTeamInfo[$i]['type_id'] = $validated['type_id'];
                    $gameTeamInfo[$i]['team_title'] = 'Team ' . $i;
                }
                GameTeam::insert($gameTeamInfo);
            }*/
            if(!(empty($request->question_id))){
              

                $query->questions()->sync([
                    "brand_id" => $request->input('brand_id'),
                    "game_id" => $request->input('game_id'),
                    "question_id" => $request->input('question_id'),                    
                    
                ]);
            }
            dd();

            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageError'), 'status' => false];
        }

        return response()->json($arr);
    }

    public function edit(Game $game)
    {
        if (view()->exists('backend.games.edit')) {
            $compact = [
                'updateRoute' => route($this->ROUTE_PREFIX . '.update', $game->id),
                'row' => $game,
                'types' => Type::select('id', 'title')->get(),
                'events' => Event::select('id', 'title')
                    ->where('start_date', '>', date('Y-m-d'))
                    ->get(),
                'destroyRoute' => route($this->ROUTE_PREFIX . '.destroy', $game->id),
                'redirect_after_destroy' => route($this->ROUTE_PREFIX . '.index'),
                'trans' => $this->TRANS,
            ];
            return view('backend.games.edit', $compact);
        }
    }

    /////////////
    public function update(GameRequest $request, Game $game)
    {
        $validated = $request->validated();
        $validated['image'] = !empty($request->file('image')) ? $this->uploadFile($request->file('image'), $this->UPLOADFOLDER) : null;
        $validated['slug'] = Str::slug($request->title);

        if (Game::findOrFail($game->id)->update($validated)) {
            $arr = ['msg' => __($this->TRANS . '.updateMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroy(Game $game)
    {
        //SET ALL childs to NULL
        if ($game->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'deleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'deleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        $items = Game::whereIn('id', $ids); // Check
        if ($items->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'MulideleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'MiltideleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }

    public function AjaxgetQuestionsByBrand(Request $request){
        $questions = Question::where('brand_id',$request->brand_id)->get();
        $view = view('backend.games.AjaxGetQuestions',['questions'=>$questions])->render();
        return $view; 
    }
}
