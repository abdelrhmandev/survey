<?php
namespace App\Http\Controllers\backend;
use Hash;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Country;
use App\Models\Team;
use App\Traits\Functions;
use App\Traits\UploadAble;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role as Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\backend\UserRequest;
use App\Http\Requests\backend\UpdateUserRequest;

class UserController extends Controller
{
    use UploadAble, Functions;
    public function __construct()
    {
        $this->ROUTE_PREFIX =  'admin.users';
        $this->TRANS        = 'user';
        $this->Tbl          = 'users';
        $this->UPLOADFOLDER = 'avatars';
    }


    public function store(UserRequest $request)
    {

        $arry = [
            'name'       => $request->input('name'),
            'email'      => $request->input('email'),
            'mobile'     => $request->input('mobile'),
            'avatar'     => !empty($request->file('avatar')) ? $this->uploadFile($request->file('avatar'), $this->UPLOADFOLDER) : null,
            'username'   => $request->input('username'),
            'password'   => Hash::make($request->input('password')),
            'status'     => isset($request->status) ? '1' : '0',
            'is_admin'   =>'1',
            'country_id' => $request->input('country_id'),
        ];
        $user = User::create($arry);

        if ($user && $user->assignRole($request->input('roles'))) {

            if(!(empty($request->input('teams')))){
                $tagTeamsArr = json_decode($request->input('teams'), true);
                $tagTeamList = array_column($tagTeamsArr, 'value');
                foreach($tagTeamList as $v){
                    $team = Team::firstOrCreate(['title' => $v]);
                }
                $teams = Team::whereIn('title', $tagTeamList)->pluck('id');
                $user->teams()->sync($teams);
                ///
            }


            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function create()
    {

        $compact = [
            'roles'          => Role::pluck('name','name')->all(),
            'countries'      => Country::select('id', 'name')->get(),
            'teams'          => Team::select('id', 'title')->get(),
            'trans'          => $this->TRANS,
            'listingRoute'   => route($this->ROUTE_PREFIX . '.index'),
            'storeRoute'     => route($this->ROUTE_PREFIX . '.store'),
        ];
        return view('backend.users.create', $compact);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = User::select('id', 'name', 'mobile', 'email', 'avatar','country_id', 'status', 'created_at')
                ->with([
                    'roles' => function ($query) {
                        $query->select('id', 'name'); # Many to many
                    },
                    'teams' => function ($query) {
                        $query->select('teams.id', 'teams.title'); # Many to many
                    },
                    'country' => function ($query) {
                        $query->select('countries.id', 'countries.name'); # Many to many
                    },
                ])
                ->withCount(['roles','teams']);
            return Datatables::of($model)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    $avatar = !empty($row->avatar) ? asset($row->avatar) : asset('assets/backend/media/avatars/blank.png');
                    return "<div class=\"d-flex align-items-center\">
                    <div class=\"symbol symbol-circle symbol-50px overflow-hidden me-3\">
                        <a href=".route('admin.users.edit',$row->id).">
                            <div class=\"symbol-label\">
                                <img src=" .
                        $avatar .
                        ' alt=' .
                        $row->name .
                        " class=\"w-100\" />
                            </div>
                        </a>
                    </div>
                    <div class=\"d-flex flex-column\">
                        <a href=" .route('admin.users.edit',$row->id).
                        " class=\"text-gray-800 text-hover-primary mb-1\">" .
                        $row->name .
                        "</a>
                        <span><a href=\"mailto:" .
                        $row->email .
                        "\">" .
                        $row->email .
                        "</a>
                        <br>
                        <span class=\"menu-icon me-0\">
                        <i class=\"ki-outline ki-phone fs-1x\"></i>
                    </span>
                        ".$row->mobile ?? ''."
                    </div>
                </div>";
                })
                ->AddColumn('roles', function (User $row) {
                    $roleDiv = '';
                    if ($row->roles_count > 0) {
                        foreach ($row->roles as $role) {
                                $roleDiv .= "<div class=\"badge py-3 px-4 fs-7 badge-light-primary\"><span class=\"text-primary\">" . $role->name . '</span></div> ';
                        }
                    } else {
                        $roleDiv = "<span class=\"text-danger\">" . __('user.no_roles_assigned') . '</span>';
                    }
                    return $roleDiv;
                })

                ->AddColumn('teams', function ($row) {
                    $teamDiv = '';
                    if ($row->teams_count > 0) {
                    foreach ($row->teams as $team) {
                    $teamDiv .= "<div class=\"badge py-3 px-4 fs-7 badge-light-info mt-1\"><span class=\"text-info\">" . $team->title . '</span></div> ';
                    }
                    } else {
                    $teamDiv = "<span class=\"text-danger\">" . __('user.no_teams_assigned') . '</span>';
                    }
                    return $teamDiv;
                    })

                ->editColumn('country_id', function (User $row) {
                    return $row->country->name;
                })
                ->editColumn('status', function (User $row) {
                    if ($row->status == 1) {
                        $checked = 'checked';
                        $statusLabel = "<span class=\"text-success\">" . __('site.active') . '</span>';
                    } else {
                        $checked = '';
                        $statusLabel = "<span class=\"text-danger\">" . __('site.deactivated') . '</span>';
                    }
                    $div = "<div class=\"form-check form-switch form-check-custom form-check-solid\"><input class=\"form-check-input UpdateStatus\" name=\"Updatetatus\" type=\"checkbox\" " . $checked . " id=\"Status" . $row->id . "\" onclick=\"UpdateStatus($row->id,'" . __($this->TRANS . '.plural') . "','$this->Tbl','" . route('admin.UpdateStatus') . "')\" />&nbsp;" . $statusLabel . '</div>';
                    return $div;
                })
                ->editColumn('created_at', function (User $row) {
                    return $this->dataTableGetCreatedat($row->created_at);
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
                })
                ->editColumn('actions', function ($row) {
                    return $this->dataTableEditRecordAction($row, $this->ROUTE_PREFIX);
                })
                ->rawColumns(['name', 'roles', 'status', 'teams','actions', 'created_at', 'created_at.display'])
                ->make(true);
        }
        if (view()->exists('backend.users.index')) {
            $compact = [
                'trans'                => $this->TRANS,
                'createRoute'          => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute'           => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute' => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute'         => route($this->ROUTE_PREFIX . '.index'),
                'allrecords'           => User::count(),
            ];
            return view('backend.users.index', $compact);
        }
    }
    public function edit(User $user)
    {
        if (view()->exists('backend.users.edit')) {
            $compact = [
                'updateRoute'            => route($this->ROUTE_PREFIX . '.update', $user->id),
                'row'                    => $user,
                'destroyRoute'           => route($this->ROUTE_PREFIX . '.destroy', $user->id),
                'trans'                  => $this->TRANS,
                'roles'                  => Role::pluck('name','name')->all(),
                'userRole'               => $user->roles->pluck('name','name')->all(),
                'teams'                  => Team::select('id', 'title')->get(),
                'countries'              => Country::select('id', 'name')->get(),
                'redirect_after_destroy' => route($this->ROUTE_PREFIX . '.index'),
                'editPasswordRoute'      => route($this->ROUTE_PREFIX.'.editpassword',$user->id),
                'updatePasswordRoute'    => route($this->ROUTE_PREFIX.'.updatepassword',$user->id),
            ];
            return view('backend.users.edit', $compact);
        }
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $avatar = $user->avatar;
        if(!empty($request->file('avatar'))) {
            $avatar && File::exists(public_path($avatar)) ? $this->unlinkFile($avatar): '';
            $avatar =  $this->uploadFile($request->file('avatar'),$this->UPLOADFOLDER);
         }
        $arry = [
            'name'       => $request->input('name'),
            'email'      => $request->input('email'),
            'mobile'     => $request->input('mobile'),
            'avatar'     => $avatar,
            'username'   => $request->input('username'),
            'status'     => isset($request->status) ? '1' : '0',
            'is_admin'   =>'1',
            'country_id' => $request->input('country_id'),
        ];


        $update = $user->update($arry);

        if ($update && $user->assignRole($request->input('roles'))) {

            $user->teams()->sync((array) $request->input('teams'));

            $arr = ['msg' => __($this->TRANS . '.updateMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroy(User $user)
    {
        if ($user->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'deleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'deleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }


    public function editpassword($userId){

        if (view()->exists('backend.users.editpassword')) {
            $compact = [
            'trans'                => $this->TRANS,
            'row'                 =>  User::find($userId),
            'updatePasswordRoute'  => route($this->ROUTE_PREFIX.'.updatepassword'),
        ];
            return view('backend.users.editpassword',$compact);
        }
    }

    public function updatepassword(Request $request){
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string'
        ]);
        $auth = \Auth::guard('admin')->user();
        if (!Hash::check($request->get('current_password'), $auth->password)) {
            $arr = array('msg' => __('passwords.invalid_current'), 'status' => false);
        }
        if (Hash::check($request->get('current_password'), $auth->password)) {
            $user =  User::find($auth->id);
            $user->password =  Hash::make($request->new_password);
            $user->save();
            $arr = array('msg' =>__('passwords.updated'), 'status' => true);
        }
        return response()->json($arr);
    }

    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        $items = User::whereIn('id', $ids); // Check
        if ($items->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'MulideleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'MiltideleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
}
