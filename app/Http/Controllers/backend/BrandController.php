<?php
namespace App\Http\Controllers\Backend;
use DataTables;
use Carbon\Carbon;
use App\Models\Brand;
use App\Traits\Functions;
use App\Traits\UploadAble;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\backend\BrandRequest;

class BrandController extends Controller
{
    use UploadAble, Functions;
    public function __construct()
    {
        $this->ROUTE_PREFIX = 'admin.brands';
        $this->TRANS = 'brand';
        $this->UPLOADFOLDER = 'brands';
    }

    public function index(Request $request)
    {
        $model = Brand::select('*');
            
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
                ->AddColumn('groups_count', function ($row) {
                    return 'asdas';
                })
                ->editColumn('actions', function ($row) {
                    // "<span class=\"text-dark fw-bolder fs-3\">".$row->questions_count."</span>&nbsp;".$addQestion;
                    return $this->dataTableEditRecordAction($row, $this->ROUTE_PREFIX);
                })

                ->rawColumns(['title', 'group_count', 'actions', 'created_at', 'created_at.display'])
                ->make(true);
        }
        if (view()->exists('backend.brands.index')) {
            $compact = [
                'trans'                 => $this->TRANS,
                'createRoute'           => route($this->ROUTE_PREFIX . '.create'),
                'storeRoute'            => route($this->ROUTE_PREFIX . '.store'),
                'destroyMultipleRoute'  => route($this->ROUTE_PREFIX . '.destroyMultiple'),
                'listingRoute'          => route($this->ROUTE_PREFIX . '.index'),
            ];
            return view('backend.brands.index', $compact);
        }
    }
    public function create()
    {
        if (view()->exists('backend.brands.create')) {
            $compact = [
                'brands'        => Brand::select('id', 'title')->withCount('groups')->get(),
                'trans'         => $this->TRANS,
                'listingRoute'  => route($this->ROUTE_PREFIX . '.index'),
                'storeRoute'    => route($this->ROUTE_PREFIX . '.store'),
            ];
            return view('backend.brands.create', $compact);
        }
    }
    public function store(BrandRequest $request)
    {
        $validated = $request->validated();

 

        //Draw brand Team Records
        $query = Brand::create($validated);
        if ($query) {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'storeMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }

    public function edit(Brand $brand)
    {
        if (view()->exists('backend.brands.edit')) {
            $compact = [
                'updateRoute'             => route($this->ROUTE_PREFIX . '.update', $brand->id),
                'row'                     => $brand,
                'questions'               => Question::where('brand_id', $brand->brand_id)->get(),
                'brands'                  => Brand::select('id', 'title')->withCount('questions')->get(),
                'destroyRoute'            => route($this->ROUTE_PREFIX . '.destroy', $brand->id),
                'redirect_after_destroy'  => route($this->ROUTE_PREFIX . '.index'),
                'trans'                   => $this->TRANS,
            ];
            return view('backend.brands.edit', $compact);
        }
    }

    /////////////
    public function update(BrandRequest $request, Brand $brand)
    {
        $validated = $request->validated();
        $EventDateRange = explode(' - ', $request->event_date_range);

        //////////
        $image = $brand->image;
        if (!empty($request->file('image'))) {
            $brand->image && File::exists(public_path($brand->image)) ? $this->unlinkFile($brand->image) : '';
            $image = $this->uploadFile($request->file('image'), $this->UPLOADFOLDER);
        }
        if (isset($request->drop_image_checkBox) && $request->drop_image_checkBox == 1) {
            $this->unlinkFile($brand->image);
            $image = null;
        }

        if (Brand::findOrFail($brand->id)->update($brandArr)) {
            $arr = ['msg' => __($this->TRANS . '.updateMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'updateMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroy(Brand $brand){
        if ($brand->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'deleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'deleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }
    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        $items = Brand::whereIn('id', $ids); // Check
        if ($items->delete()) {
            $arr = ['msg' => __($this->TRANS . '.' . 'MulideleteMessageSuccess'), 'status' => true];
        } else {
            $arr = ['msg' => __($this->TRANS . '.' . 'MiltideleteMessageError'), 'status' => false];
        }
        return response()->json($arr);
    }

}
