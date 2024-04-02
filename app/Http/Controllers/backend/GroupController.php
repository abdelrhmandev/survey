<?php
namespace App\Http\Controllers\Backend;
use DataTables;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Group;
use App\Models\Question;
use App\Traits\Functions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\GroupQuestion;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\backend\GroupRequest;

class GroupController extends Controller
{
    use Functions;
    public function __construct()
    {
        $this->ROUTE_PREFIX = 'admin.groups';
        $this->TRANS = 'group';
    }

    public function index(Request $request){
        $model = Group::with('brand')->withCount('questions');
            
        if ($request->ajax()) {
            return Datatables::of($model)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    return '<a href=' . route($this->ROUTE_PREFIX . '.edit', $row->id) . " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" . $row->id . "=\"item\">" . Str::words($row->title, '5') . '</a>';
                })

               
                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })

                ->editColumn('created_at', function ($row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })
                ->editColumn('brand', function ($row) {
                    return "<span class=\"text-dark fw-bolder\">".$row->brand->title."</span>";
                })
                ->AddColumn('questions', function ($row) {
                    return "<span class=\"text-dark fw-bolder\">".$row->questions_count."</span>";
                })

                ->AddColumn('reorder', function ($row) {
                    return $row->questions_count > 0 ? '<a href=' . route('admin.group.qestions', $row->id) . " class=\"btn btn-sm btn-light-primary\"><i class=\"ki-outline ki-arrows-circle fs-3\"></i>Reorder&nbsp;&nbsp":'No Questions';
                })

                ->editColumn('actions', function ($row) {
                    return $this->dataTableEditRecordAction($row, $this->ROUTE_PREFIX);
                })

                ->rawColumns(['title', 'brand','questions','reorder', 'actions', 'created_at', 'created_at.display'])
                ->make(true);
        }
        if (view()->exists('backend.groups.index')) {
            $compact = [
                'trans'                 => $this->TRANS,
                'createRoute'           => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute'            => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute'  => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute'          => route($this->ROUTE_PREFIX . '.index'),
            ];
            return view('backend.groups.index', $compact);
        }
    }
    public function create()
    {
        if (view()->exists('backend.groups.create')) {
            $compact = [
                'brands'        => Brand::select('id', 'title')->get(),
                'trans'         => $this->TRANS,
                'listingRoute'  => route($this->ROUTE_PREFIX . '.index'),
                'storeRoute'    => route($this->ROUTE_PREFIX . '.store'),
            ];
            return view('backend.groups.create', $compact);
        }
    }

    public function AjaxgetQuestionsByBrand(Request $request)
    {
        $questions = Question::where('brand_id', $request->brand_id)->get();
        $view = view('backend.groups.AjaxGetQuestions', ['questions' => $questions])->render();
        return $view;
    }

    public function store(GroupRequest $request)
    {
        $validated = $request->validated();
        //Draw brand Team Records
        $query = Group::create($validated);

        $arr = [];
        foreach($request->input('question_id') as $question_id){
            $arr[$question_id] = ['group_id'=>$query->id,'question_id'=>$question_id];
        }

        if ($query && GroupQuestion::insert($arr)) {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }

    public function edit(Group $group)
    {
        if (view()->exists('backend.groups.edit')) {
            $compact = [
                'updateRoute'             => route($this->ROUTE_PREFIX . '.update', $group->id),
                'row'                     => $group,
                'brands'                  => Brand::select('id', 'title')->get(),
                'questions'               => Question::where('brand_id',$group->brand_id)->get(),
                'destroyRoute'            => route($this->ROUTE_PREFIX . '.destroy', $group->id),
                'redirect_after_destroy'  => route($this->ROUTE_PREFIX . '.index'),
                'trans'                   => $this->TRANS,
            ];
            return view('backend.groups.edit', $compact);
        }
    }
    public function ReorderGroupQestions($group_id)
    {
        if (view()->exists('backend.groups.ReorderGroupQuestions')) {
            $compact = [
                'GroupQuestions'          => GroupQuestion::where('group_id',$group_id)->with('question')->get(),
                'redirect_after_destroy'  => route($this->ROUTE_PREFIX . '.index'),
                'trans'                   => $this->TRANS,
            ];
            return view('backend.groups.ReorderGroupQuestions', $compact);
        }
    }


    


 
    public function update(GroupRequest $request, Group $group)
    {
        $validated = $request->validated();    
        $group->questions()->sync((array) $request->input('question_id'));
        if (Group::findOrFail($group->id)->update($validated)) {
            $arr = ['msg' => __($this->TRANS . '.updateMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroy(Group $group){
        if ($group->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'deleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'deleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        $items = Group::whereIn('id', $ids); // Check
        if ($items->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'MulideleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'MiltideleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }

}
