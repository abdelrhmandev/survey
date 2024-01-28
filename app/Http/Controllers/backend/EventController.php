<?php
namespace App\Http\Controllers\backend;
use App\Http\Requests\backend\EventRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Traits\Functions;
use App\Traits\UploadAble;
use DataTables;
class EventController extends Controller
{
    use UploadAble, Functions;
    public function __construct()
    {
        $this->ROUTE_PREFIX = 'admin.events';
        $this->TRANS = 'event';
        $this->UPLOADFOLDER = 'events';
    }

    public function index(Request $request)
    {
        $model = Event::select('*')->withCount(['games']);
        if ($request->ajax()) {
            return Datatables::of($model)
                ->addIndexColumn()


                ->editColumn('title', function ($row) {
                    $EventHit = '';
                    if($row->end_date < date('Y-m-d')) $EventHit = "<div class=\"text-danger\">Expired</div>";
                    
                    return '<a href=' . route($this->ROUTE_PREFIX . '.edit', $row->id) . " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" . $row->id . "=\"item\">" . Str::words($row->title, '5') . '</a>'.$EventHit;
                })


                ->addColumn('games', function ($row) {
                    return $row->games_count;
                })

                ->editColumn('image', function ($row) {
                    return $this->dataTableGetImage($row, $this->ROUTE_PREFIX . '.edit');
                })

                ->editColumn('start_date', function ($row) {
                    return $div = "<div class=\"font-weight-bolder text-success mb-0\">".Carbon::parse($row->start_date)->format('d/m/Y').'</div><div class=\"text-muted\">'.Carbon::parse($row->start_date)->diffForHumans()."</div>";
                })

                ->editColumn('end_date', function ($row) {
                    return $div = "<div class=\"font-weight-bolder text-danger mb-0\">".Carbon::parse($row->end_date)->format('d/m/Y').'</div><div class=\"text-muted\">'.Carbon::parse($row->end_date)->diffForHumans()."</div>";
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
                ->rawColumns(['image','title','start_date', 'end_date','actions', 'created_at', 'created_at.display'])
                ->make(true);
        }
        if (view()->exists('backend.events.index')) {
            $compact = [
                'trans' => $this->TRANS,
                'createRoute' => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute' => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute' => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute' => route($this->ROUTE_PREFIX . '.index'),
            ];
            return view('backend.events.index', $compact);
        }
    }
    public function create()
    {
        if (view()->exists('backend.events.create')) {
            $compact = [
                'trans' => $this->TRANS,
                'listingRoute' => route($this->ROUTE_PREFIX . '.index'),
                'storeRoute' => route($this->ROUTE_PREFIX . '.store'),
            ];
            return view('backend.events.create', $compact);
        }
    }
    public function store(EventRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = !empty($request->file('image')) ? $this->uploadFile($request->file('image'), $this->UPLOADFOLDER) : null;
        $validated['slug'] = Str::slug($request->title);

        $EventDateRange = explode(" - ", $request->event_date_range);
        $validated['start_date'] = $EventDateRange[0];
        $validated['end_date'] = $EventDateRange[1];
        if (Event::create($validated)) {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageError'), 'status' => false];
        }

        return response()->json($arr);
    }

    public function edit(Event $event)
    {
        if (view()->exists('backend.events.edit')) {
            $compact = [
                'updateRoute' => route($this->ROUTE_PREFIX . '.update', $event->id),
                'row' => $event,
                'destroyRoute' => route($this->ROUTE_PREFIX . '.destroy', $event->id),
                'redirect_after_destroy' => route($this->ROUTE_PREFIX . '.index'),
                'trans' => $this->TRANS,
            ];
            return view('backend.events.edit', $compact);
        }
    }

    /////////////
    public function update(EventRequest $request, Event $event)
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

        if (Event::findOrFail($event->id)->update($validated)) {
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
        $items = Event::whereIn('id', $ids); // Check
        if ($items->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'MulideleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'MiltideleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
}
