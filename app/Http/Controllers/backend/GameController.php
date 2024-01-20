<?php
namespace App\Http\Controllers\backend;
use App\Http\Requests\backend\GameRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Game;
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
        $model = Game::select('*')->with(['type','event']);
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
                    return "<span class=\"text-gray-800 fw-bolder fs-3\">".$row->attendees."</span>";
                })

                

                ->editColumn('play_with_team', function ($row) {

                    return "<div class=\"badge py-3 px-4 fs-7 badge-light-".($row->play_with_team == '1' ? 'primary':'danger')."\"><span class=\"text-".($row->play_with_team == '1' ? 'sccuess':'danger')."\">".($row->play_with_team == '1' ? 'Yes':'No')."</span></div>";
                })

                ->editColumn('team_players', function ($row) {

                    return "<span class=\"text-gray-800 fw-bolder fs-3\">".($row->play_with_team == '1' && $row->team_players ? $row->team_players:'-')."</span>";
                })


                ->editColumn('event_id', function ($row) {
                    return $row->event->title;
                })

                ->editColumn('type_id', function ($row) {
                    return $row->type->title;

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
                ->rawColumns(['image','title','attendees','play_with_team', 'team_players','actions', 'created_at', 'created_at.display'])
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
                'types' =>Type::select('id','title')->get(),
                'events' =>Event::select('id','title')->where('start_date','>',date('Y-m-d'))->get(),
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


        if (Game::create($validated)) {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageError'), 'status' => false];
        }

        return response()->json($arr);
    }

    public function edit(Event $event)
    {
        if (view()->exists('backend.games.edit')) {
            $compact = [
                'updateRoute' => route($this->ROUTE_PREFIX . '.update', $event->id),
                'row' => $event,
                'destroyRoute' => route($this->ROUTE_PREFIX . '.destroy', $event->id),
                'redirect_after_destroy' => route($this->ROUTE_PREFIX . '.index'),
                'trans' => $this->TRANS,
            ];
            return view('backend.games.edit', $compact);
        }
    }

    /////////////
    public function update(GameRequest $request, Event $event)
    {

        $validated = $request->validated();

        $validated['slug'] = Str::slug($request->title);


        $EventDateRange = explode(" - ", $request->event_date_range);
        $validated['start_date'] = $EventDateRange[0];
        $validated['end_date'] = $EventDateRange[1];

        $image = $event->image;
        if (!empty($request->file('image'))) {
            $event->image && File::exists(public_path($event->image)) ? $this->unlinkFile($event->image) : '';
            $image = $this->uploadFile($request->file('image'), $this->UPLOADFOLDER);
        }
        if (isset($request->drop_image_checkBox) && $request->drop_image_checkBox == 1) {
            $this->unlinkFile($event->image);
            $image = null;
        }
        $validated['image'] = $image;

        if (Game::findOrFail($event->id)->update($validated)) {
            $arr = ['msg' => __($this->TRANS . '.updateMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroy(Event $event)
    {
        //SET ALL childs to NULL
        if ($event->delete()) {
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
