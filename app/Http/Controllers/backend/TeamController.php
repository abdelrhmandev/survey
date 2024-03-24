<?php
namespace App\Http\Controllers\Backend;
use App\Http\Requests\backend\TeamRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\Functions;
use DataTables;
class TeamController extends Controller
{
    use Functions;
    public function __construct()
    {

        $this->ROUTE_PREFIX =  'admin.teams';
        $this->TRANS = 'team';  
    }

    public function index(Request $request)
    {
        $model = Team::select('*')->withCount('users');
        if ($request->ajax()) {
            return Datatables::of($model)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    return '<a href=' . route($this->ROUTE_PREFIX . '.edit', $row->id) . " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" . $row->id . "=\"item\">" . Str::words($row->title, '5') . '</a>';
                })


                ->addColumn('users', function ($row) {
                    return $row->users_count;
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                 })
                 ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                 })             
                    ->editColumn('actions', function ($row) {                                                       
                        return $this->dataTableEditRecordAction($row,$this->ROUTE_PREFIX);
                    })                         
                ->rawColumns(['title','actions','created_at','created_at.display'])                  
                ->make(true);
        }
        if (view()->exists('backend.teams.index')) {
            $compact = [
                'trans'                 => $this->TRANS,
                'createRoute'           => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute'            => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute'  => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute'          => route($this->ROUTE_PREFIX . '.index'),
            ];
            return view('backend.teams.index', $compact);
        }
    }
    public function create()
    {
        if (view()->exists('backend.teams.create')) {
            $compact = [
                'trans'         => $this->TRANS,
                'listingRoute'  => route($this->ROUTE_PREFIX . '.index'),
                'storeRoute'    => route($this->ROUTE_PREFIX . '.store'),
                'teams'          => Team::with('posts'),
            ];
            return view('backend.teams.create', $compact);
        }
    }
    public function store(TeamRequest $request){
            $validated  = $request->validated();                     
            $validated['slug'] = Str::slug($request->title);
            if(Team::create($validated)){              
                     $arr = array('msg' => __($this->TRANS.'.'.'storeMessageSuccess'), 'status' => true);              
            }else{
                $arr = array('msg' => __($this->TRANS.'.'.'storeMessageError'), 'status' => false);
            }
        
        return response()->json($arr);
        
}


    public function edit(Team $team)
    {
        if (view()->exists('backend.teams.edit')) {
            $compact = [
                'updateRoute'             => route($this->ROUTE_PREFIX . '.update', $team->id),
                'row'                     => $team,
                'destroyRoute'            => route($this->ROUTE_PREFIX . '.destroy', $team->id),
                'redirect_after_destroy'  => route($this->ROUTE_PREFIX . '.index'),
                'trans'                   => $this->TRANS,
            ];
            return view('backend.teams.edit', $compact);
        }
    }

    /////////////
    public function update(TeamRequest $request, Team $team){
        
        $validated = $request->validated();
        $validated['slug'] = Str::slug($request->title);
        if (Team::findOrFail($team->id)->update($validated)) {
        
        $arr = ['msg' => __($this->TRANS.'.updateMessageSuccess'), 'status' => true];
        }else{
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroy(Team $team){        
        //SET ALL childs to NULL 
        if($team->delete()){
            $arr = array('msg' => __($this->TRANS.'.'.'deleteMessageSuccess'), 'status' => true);
        }else{
            $arr = array('msg' => __($this->TRANS.'.'.'deleteMessageError'), 'status' => false);
        }        
        return response()->json($arr);
    }
    public function destroyMultiple(Request $request){  
        $ids = explode(',', $request->ids);
        $items = Team::whereIn('id',$ids); // Check          
        if($items->delete()){
            $arr = array('msg' => __($this->TRANS.'.'.'MulideleteMessageSuccess'), 'status' => true);
        }else{
            $arr = array('msg' => __($this->TRANS.'.'.'MiltideleteMessageError'), 'status' => false);
        }        
        return response()->json($arr);
    }
}
