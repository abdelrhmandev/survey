<?php
namespace App\Http\Controllers\Backend;
use DataTables;
use Carbon\Carbon;
use App\Models\Game;
use App\Models\Type;
use App\Models\Brand;
use App\Models\Group;
use App\Models\GameTeam;
use App\Models\Question;
use App\Traits\Functions;
use App\Traits\UploadAble;
use Illuminate\Support\Str;
use App\Models\GameQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\backend\GameRequest;

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
        $model = Game::select('id','pin','image','title','event_title','event_start_date','event_end_date','slug','type_id','group_id','brand_id','created_at')->with(['type','group.questions', 'brand','user']);

            
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
                        '</a><div class=\"border border-gray-300 border-dashed rounded min-w-60px w-60 py-2 px-4 me-6 mb-3\">' .
                        'Pin : <span style="color:#b04949;">' . $row->pin . '</span>';
                        
                })

                ->editColumn('image', function ($row) {
                    return $this->dataTableGetImage($row, $this->ROUTE_PREFIX . '.edit');
                })

                ->editColumn('event_title', function ($row) {
                    return $row->event_title.
                    
                    "<div class=\"me-6\">
                        <span class=\"font-weight-bolder text-success mb-0\">" .Carbon::parse($row->event_start_date)->format('d M Y') ."</span>
                         - <span class=\"font-weight-bolder text-info mb-0\">" .Carbon::parse($row->event_end_date)->format('d M Y') ."</span>
                    </div>"
                    .($row->event_end_date < date('Y-m-d') ? "<div class=\"text-danger\">Expired</div>" : '');
                    ;                    
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })
                ->editColumn('type', function ($row) {
                    return '<a href=' .
                    route('admin.types.edit', $row->type_id) .
                    " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" .
                    $row->id .
                    "=\"item\">" .
                    $row->type->title .
                    '</a>';
                })

                ->editColumn('brand', function ($row) {
                    return '<a href=' .
                    route('admin.brands.edit', $row->brand_id) .
                    " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" .
                    $row->id .
                    "=\"item\">" .
                    $row->brand->title .
                    '</a>';
                })

                ->editColumn('group', function ($row) {
                    return '<a href=' . route('admin.group.qestions', $row->group_id) . " class=\"btn btn-sm btn-light-primary\"><i class=\"ki-outline ki-arrows-circle fs-3\"></i>". $row->group->title.'&nbsp;&nbsp;'.'('.$row->group->questions->count().')';
                })
 


                ->editColumn('actions', function ($row) {

                    return $this->dataTableEditRecordAction2($row, $this->ROUTE_PREFIX);
                })

                ->rawColumns(['image', 'title', 'event_title','type','brand', 'group', 'actions', 'created_at', 'created_at.display'])
                ->make(true);
        }
        if (view()->exists('backend.games.index')) {
            $compact = [
                'trans'                 => $this->TRANS,
                'createRoute'           => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute'            => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute'  => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute'          => route($this->ROUTE_PREFIX . '.index'),
            ];
            return view('backend.games.index', $compact);
        }
    }
    public function create()
    {
        if (view()->exists('backend.games.create')) {
            $compact = [
                'types'         => Type::select('id', 'title')->get(),
                'brands'        => Brand::select('id', 'title')->withCount('groups')->get(),
                'trans'         => $this->TRANS,
                'listingRoute'  => route($this->ROUTE_PREFIX . '.index'),
                'storeRoute'    => route($this->ROUTE_PREFIX . '.store'),
            ];
            return view('backend.games.create', $compact);
        }
    }
    public function store(GameRequest $request)
    {
        $validated = $request->validated();
        $EventDateRange = explode(' - ', $request->event_date_range);
        $GameArr = [
            'title'             => $validated['title'],
            'slug'              => Str::slug($validated['title']),
            'image'             => !empty($validated['image']) ? $this->uploadFile($validated['image'], $this->UPLOADFOLDER) : null,
            'description'       => $validated['description'],
            'color'             => $validated['color'] ?? null,
            'attendees'         => $validated['attendees'],
            'type_id'           => $validated['type_id'],
            'brand_id'          => $validated['brand_id'],
            'group_id'          => $validated['group_id'],
            'play_with_team'    => $validated['play_with_team'] ?? '0',
            'team_players'      => $validated['team_players'] ?? null,
            'event_title'       => $validated['event_title'],
            'event_start_date'  => $EventDateRange[0],
            'event_end_date'    => $EventDateRange[1],
            'event_location'    => $validated['event_location'],
            'user_id'           =>Auth::guard('admin')->user()->id,
            'pin'               => \Str::random(10),
        ];
        //Draw Game Team Records
        $query = Game::create($GameArr);
        if ($query) {
            if ($request->play_with_team && $request->play_with_team == '1') {
                $TeamRecords = ceil($validated['attendees'] / $validated['team_players']);
                $gameTeamInfo = [];
                for ($i = 1; $i <= $TeamRecords; $i++) {
                    $gameTeamInfo[$i]['game_id']    = $query->id;
                    $gameTeamInfo[$i]['team_title'] = 'Team ' . $i;
                    $gameTeamInfo[$i]['capacity']   = $TeamRecords;
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

    public function edit(Game $game)
    {
        if (view()->exists('backend.games.edit')) {
            $compact = [
                'updateRoute'            => route($this->ROUTE_PREFIX . '.update', $game->id),
                'row'                    => $game,
                'types'                  => Type::select('id', 'title')->get(),
                'groups'                 => Group::select('id', 'title')->where('brand_id',$game->brand_id)->withCount('questions')->get(),
                'destroyRoute'           => route($this->ROUTE_PREFIX . '.destroy', $game->id),
                'redirect_after_destroy' => route($this->ROUTE_PREFIX . '.index'),
                'trans'                  => $this->TRANS,
            ];
            return view('backend.games.edit', $compact);
        }
    }

    /////////////
public function update(GameRequest $request, Game $game)
    {

      
        $validated = $request->validated();
        $EventDateRange = explode(' - ', $request->event_date_range);

        //////////
        $image = $game->image;
        if (!empty($request->file('image'))) {
            $game->image && File::exists(public_path($game->image)) ? $this->unlinkFile($game->image) : '';
            $image = $this->uploadFile($request->file('image'), $this->UPLOADFOLDER);
        }
        if (isset($request->drop_image_checkBox) && $request->drop_image_checkBox == 1) {
            $this->unlinkFile($game->image);
            $image = null;
        }


        ////////////

        $GameArr = [
            'title'             => $validated['title'],
            'slug'              => Str::slug($validated['title']),
            'image'             => $image,
            'description'       => $validated['description'],
            'color'             => $validated['color'] ?? null,
            'attendees'         => $validated['attendees'],
            'type_id'           => $validated['type_id'],
            'brand_id'          => $validated['brand_id'],
            'group_id'          => $validated['group_id'],
            'play_with_team'    => $validated['play_with_team'] ?? '0',
            'team_players'      => $validated['team_players'] ?? null,
            'event_title'       => $validated['event_title'],
            'event_start_date'  => $EventDateRange[0],
            'event_end_date'    => $EventDateRange[1],
            'event_location'    => $validated['event_location'],
        ];
        if (Game::findOrFail($game->id)->update($GameArr)) {
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

    public function GetQuestions($game_id)
    {
        if (view()->exists('backend.games.edit')) {
            $compact = [
                'trans' => 'question',
                'Gamequestions' => GameQuestion::with('question')->where('game_id', $game_id)->orderBy('order','asc')->get(),
            ];

            return view('backend.games.ReorderQuestions', $compact);
        }
    }
    public function AjaxgetGroupsByBrand(Request $request)
    {
        $groups = Group::where('brand_id', $request->brand_id)->withCount('questions')->get();
        $view = view('backend.games.AjaxGetGroups', ['groups' => $groups])->render();
        return $view;
    }
}
