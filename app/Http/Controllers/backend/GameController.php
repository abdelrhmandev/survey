<?php
namespace App\Http\Controllers\backend;
use App\Http\Requests\backend\GameRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Question;
use App\Models\GameQuestion;
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
                    $type = 'Type : <a href=' . route('admin.types.edit', $row->type_id) . " class=\"text-hover-success\"  title=" . $row->type->title . '>' . $row->type->title . '</a>';

                    $brand = 'Brand : <span style="color:blue">'.$row->brand->title."</span>";

                    return '<a href=' .
                        route($this->ROUTE_PREFIX . '.edit', $row->id) .
                        " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" .
                        $row->id .
                        "=\"item\">" .
                        $row->title .
                        '</a>
                        <div class=\"border border-gray-300 border-dashed rounded min-w-60px w-60 py-2 px-4 me-6 mb-3\">' .
                        $type .
                        '</div><div class=\"border border-gray-300 border-dashed rounded min-w-60px w-60 py-2 px-4 me-6 mb-3\">' .
                        $brand .
                        '</div>
                    ';
                })

                ->editColumn('image', function ($row) {
                    return $this->dataTableGetImage($row, $this->ROUTE_PREFIX . '.edit');
                })

                ->editColumn('event_title', function ($row) {
                    // $row->event_title

                    $info =
                        "<span
                         class=\"text-gray-800 fs-5 fw-bold mb-1\">" .
                        $row->event_title .
                        "
                        </span>
                       
                        <div class=\"d-flex\">

    <div class=\"border border-gray-300 border-dashed rounded min-w-60px w-60 py-2 px-2 me-6\">
        <span class=\"font-weight-bolder text-success
            mb-0\">" .
                        Carbon::parse($row->event_start_date)->format('d/m/Y') .
                        "</span>
    </div>

                    <div class=\"\w-60 py-2 px-2 me-4\">To</div>
    <div class=\"border border-gray-300 border-dashed rounded min-w-60px w-60 py-2 px-2 me-6\">
        <span class=\"font-weight-bolder text-info
            mb-0\">" .
                        Carbon::parse($row->event_end_date)->format('d/m/Y') .
                        "</span>
    </div>

</div>


                    " .
                        ($row->event_end_date < date('Y-m-d') ? "<div class=\"text-danger\">Expired</div>" : '');
                    return $info;
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })
                ->editColumn('questions', function ($row) {
                    $ReorderListings = '<a href=' . route('admin.GetQuestions', $row->id) . " class=\"btn btn-sm btn-light-primary\"><i class=\"ki-outline ki-arrows-circle fs-3\"></i>Reorder</a>";
                    return "<span class=\"text-dark fw-bolder fs-3\">" . $row->questions_count . '</span>&nbsp;' . ($row->questions_count > 0 ? $ReorderListings : '');
                })
                ->editColumn('actions', function ($row) {
                    // "<span class=\"text-dark fw-bolder fs-3\">".$row->questions_count."</span>&nbsp;".$addQestion;

                    return $this->dataTableEditRecordAction($row, $this->ROUTE_PREFIX);
                })

                ->rawColumns(['image', 'title', 'event_title', 'questions', 'actions', 'created_at', 'created_at.display'])
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
        $EventDateRange = explode(' - ', $request->event_date_range);
        $GameArr = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'image' => !empty($validated['image']) ? $this->uploadFile($validated['image'], $this->UPLOADFOLDER) : null,
            'description' => $validated['description'],
            'color' => $validated['color'] ?? null,
            'attendees' => $validated['attendees'],
            'type_id' => $validated['type_id'],
            'brand_id' => $validated['brand_id'],
            'play_with_team' => $validated['play_with_team'] ?? '0',
            'team_players' => $validated['team_players'] ?? null,
            'event_title' => $validated['event_title'],
            'event_start_date' => $EventDateRange[0],
            'event_end_date' => $EventDateRange[1],
            'event_location' => $validated['event_location'],
        ];
        //Draw Game Team Records
        $query = Game::create($GameArr);
        if ($query) {
            if ($request->play_with_team && $request->play_with_team == '1') {
                $TeamRecords = ceil($validated['attendees'] / $validated['team_players']);
                $gameTeamInfo = [];
                for ($i = 1; $i <= $TeamRecords; $i++) {
                    $gameTeamInfo[$i]['game_id'] = $query->id;
                    $gameTeamInfo[$i]['type_id'] = $validated['type_id'];
                    $gameTeamInfo[$i]['team_title'] = 'Team ' . $i;
                }
                GameTeam::insert($gameTeamInfo);
            }
            $query->questions()->syncWithPivotValues($request->input('question_id'), ['brand_id' => $request->brand_id, 'order' => null]);

            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }

    public function edit(Game $game){
      
        if (view()->exists('backend.games.edit')) {
            $compact = [
                'updateRoute' => route($this->ROUTE_PREFIX . '.update', $game->id),
                'row' => $game,                
                'questions' => Question::where('brand_id', $game->brand_id)->get(),
                'brands' => Brand::select('id', 'title')->withCount('questions')->get(),
                'types' => Type::select('id', 'title')->get(),
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

        $EventDateRange = explode(' - ', $request->event_date_range);
        $GameArr = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'image' => !empty($validated['image']) ? $this->uploadFile($validated['image'], $this->UPLOADFOLDER) : null,
            'description' => $validated['description'],
            'color' => $validated['color'] ?? null,
            'attendees' => $validated['attendees'],
            'type_id' => $validated['type_id'],
            'brand_id' => $game->brand_id,
            'play_with_team' => $validated['play_with_team'] ?? '0',
            'team_players' => $validated['team_players'] ?? null,
            'event_title' => $validated['event_title'],
            'event_start_date' => $EventDateRange[0],
            'event_end_date' => $EventDateRange[1],
            'event_location' => $validated['event_location'],
        ];
        if (Game::findOrFail($game->id)->update($GameArr)) {
            $game->questions()->syncWithPivotValues($request->input('question_id'), ['brand_id' => $game->brand_id, 'order' => null]);

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

    
    public  function GetQuestions($game_id){

        if (view()->exists('backend.games.edit')) {
            $compact = [
                'trans' => 'question',
                'Gamequestions' => GameQuestion::with('ReorderQuestion')->where('game_id', $game_id)->get(),
            ];
           
            return view('backend.games.ReorderQuestions', $compact);
        }
    }
    public function AjaxgetQuestionsByBrand(Request $request){
        $questions = Question::where('brand_id', $request->brand_id)->get();
        $view = view('backend.games.AjaxGetQuestions', ['questions' => $questions])->render();
        return $view;
    }
}
