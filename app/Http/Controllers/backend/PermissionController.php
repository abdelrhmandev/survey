<?php
namespace App\Http\Controllers\backend;
use Carbon\Carbon;
use App\Traits\Functions;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\backend\PermissionRequest;

class PermissionController extends Controller
{
    use Functions;

    public function __construct()
    {
        $this->ROUTE_PREFIX  = 'admin.permissions';
        $this->TRANS         = 'permission';
        $this->Tbl           = 'permissions';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Permission::select('id', 'name', 'created_at')
                ->with([
                    'roles' => function ($query) {
                        $query->select('*'); # Many to many
                    },
                ])
                ->withCount(['roles']);
            return Datatables::of($model)
                ->addIndexColumn()
                ->editColumn('name', function (Permission $row) {
                    return '<a href=' .
                        route($this->ROUTE_PREFIX . '.edit', $row->id) .
                        " class=\"text-gray-800 text-hover-primary fs-5 fw-bold mb-1\" data-kt-item-filter" .
                        $row->id .
                        "=\"item\">" .
                        Str::words($row->name, '5') .
                        "</a>
                            ";
                })
                ->AddColumn('associated_roles', function (Permission $row) {
                    $RolesDiv = '';
                    if ($row->roles_count > 0) {
                        $RolesDiv = "<span class=\"text-gray-800 fw-bolder fs-3\">" . $row->roles_count . '</span><br/>';
                        foreach ($row->roles as $permission) {
                         
                        }
                    } else {
                        $RolesDiv = "<span class=\"text-danger\">" . __('permission.no_associated_role') . '</span>';
                    }
                    return $RolesDiv;
                })
                ->editColumn('created_at', function (Permission $row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                })
                ->editColumn('actions', function ($row) {
                    return $this->dataTableEditRecordAction($row, $this->ROUTE_PREFIX);
                })
                ->rawColumns(['name', 'associated_roles', 'actions', 'created_at', 'created_at.display'])
                ->make(true);
        }
        if (view()->exists('backend.permissions.index')) {
            $compact = [
                'trans'                 => $this->TRANS,
                'createRoute'           => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute'            => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute'  => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute'          => route($this->ROUTE_PREFIX . '.index'),
                'allrecords'            => Permission::count(),
            ];
            return view('backend.permissions.index', $compact);
        }
    }
    public function create()
    {
        $compact = [
            'trans'         => $this->TRANS,
            'listingRoute'  => route($this->ROUTE_PREFIX . '.index'),
            'storeRoute'    => route($this->ROUTE_PREFIX . '.store'),
        ];
        return view('backend.permissions.create', $compact);
    }

    public function store(PermissionRequest $request)
    {
        $arry = ['name' => $request->input('name')];
        if (Permission::create($arry)) {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $row = Permission::find($permission->id);
        $row->name = $request->input('name');
        if ($row->save()) {
            $arr = ['msg' => __($this->TRANS . '.updateMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }

    public function edit(Permission $permission)
    {
        if (view()->exists('backend.permissions.edit')) {
            $compact = [
                'updateRoute'            => route($this->ROUTE_PREFIX . '.update', $permission->id),
                'row'                    => $permission,
                'destroyRoute'           => route($this->ROUTE_PREFIX . '.destroy', $permission->id),
                'trans'                  => $this->TRANS,
                'redirect_after_destroy' => route($this->ROUTE_PREFIX . '.index'),
            ];
            return view('backend.permissions.edit', $compact);
        }
    }

    public function destroy($id)
    {
        dd('SOON');
    }
}
