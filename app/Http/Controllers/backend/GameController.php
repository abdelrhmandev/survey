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
        $model = Game::select('*')->with(['type', 'event']);
        if ($request->ajax()) {
            return Datatables::of($model)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    return '<a href=' . route($this->ROUTE_PREFIX . '.edit', $row->id) . " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" . $row->id . "=\"item\">" . Str::words($row->title, '5') . '</a>';
                })

                ->editColumn('image', function ($row) {
                    return $this->dataTableGetImage($row, $this->ROUTE_PREFIX . '.edit');
                })

                ->editColumn('attendees', function ($row) {
                    return "<span class=\"text-gray-800 fw-bolder fs-3\">" . $row->attendees . '</span>';
                })

                ->editColumn('play_with_team', function ($row) {
                    return "<div class=\"badge py-3 px-4 fs-7 badge-light-" . ($row->play_with_team == '1' ? 'success' : 'danger') . "\"><span class=\"text-" . ($row->play_with_team == '1' ? 'sccuess' : 'danger') . "\">" . ($row->play_with_team == '1' ? 'Yes' : 'No') . '</span></div>';
                })

                ->editColumn('team_players', function ($row) {
                    return "<span class=\"text-gray-800 fw-bolder fs-3\">" . ($row->play_with_team == '1' && $row->team_players ? $row->team_players : '-') . '</span>';
                })

                ->editColumn('event_id', function ($row) {
                    return '<a href=' . route('admin.events.edit', $row->event_id) . " class=\"text-hover-success\"  title=" . $row->event->title . '>' . $row->event->title . '</a>';
                })

                ->editColumn('type_id', function ($row) {
                    return '<a href=' . route('admin.types.edit', $row->type_id) . " class=\"text-hover-success\"  title=" . $row->type->title . '>' . $row->type->title . '</a>';
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                })
                ->editColumn('actions', function ($row) {
                    $addQestion =
                        '<a href=' .
                        route('admin.Q', $row->id) .
                        " class=\"btn btn-sm btn-light-primary\">
                    <i class=\"ki-outline ki-message-question fs-3\"></i>" .
                        __('question.add') .
                        "</a>
                ";

                    return $addQestion . $this->dataTableEditRecordAction($row, $this->ROUTE_PREFIX);
                })
                ->rawColumns(['image', 'title', 'attendees', 'type_id', 'event_id', 'play_with_team', 'team_players', 'actions', 'created_at', 'created_at.display'])
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
                'events' => Event::select('id', 'title')
                    ->where('start_date', '>', date('Y-m-d'))
                    ->get(),
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
        $validated['image'] = !empty($request->file('image')) ? $this->uploadFile($request->file('image'), $this->UPLOADFOLDER) : null;
        $validated['slug'] = Str::slug($request->title);

        //Draw Game Team Records

        $query = Game::create($validated);

        if ($query) {
            if ($request->play_with_team && $request->play_with_team == '1') {
                $TeamRecords = ceil($validated['attendees'] / $validated['team_players']);
                $gameTeamInfo = [];
                for ($i = 1; $i <= $TeamRecords; $i++) {
                    $gameTeamInfo[$i]['game_id'] = $query->id;
                    $gameTeamInfo[$i]['event_id'] = $validated['event_id'];
                    $gameTeamInfo[$i]['type_id'] = $validated['type_id'];
                    $gameTeamInfo[$i]['team_title'] = 'Team ' . $i;
                }
                GameTeam::insert($gameTeamInfo);
            }

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
                'destroyRoute' => route($this->ROUTE_PREFIX . '.destroy', $game->id),
                'redirect_after_destroy' => route($this->ROUTE_PREFIX . '.index'),
                'trans' => $this->TRANS,
            ];
            return view('backend.games.edit', $compact);
        }
    }

    /////////////
    public function update(GameRequest $request, Event $game)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($request->title);

        $gameDateRange = explode(' - ', $request->event_date_range);
        $validated['start_date'] = $gameDateRange[0];
        $validated['end_date'] = $gameDateRange[1];

        $image = $game->image;
        if (!empty($request->file('image'))) {
            $game->image && File::exists(public_path($game->image)) ? $this->unlinkFile($game->image) : '';
            $image = $this->uploadFile($request->file('image'), $this->UPLOADFOLDER);
        }
        if (isset($request->drop_image_checkBox) && $request->drop_image_checkBox == 1) {
            $this->unlinkFile($game->image);
            $image = null;
        }
        $validated['image'] = $image;

        if (Game::findOrFail($game->id)->update($validated)) {
            $arr = ['msg' => __($this->TRANS . '.updateMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroy(Event $game)
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
}
