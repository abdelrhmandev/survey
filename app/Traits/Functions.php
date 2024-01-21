<?php
namespace App\Traits;
use Illuminate\Support\Str;
use LaravelLocalization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
/**
 * Trait UploadAble
 * @package App\Traits
 */
trait Functions
{
    public function dataTableGetImage($row, $route)
    {
        $div = '<span aria-hidden="true">—</span>';
        $row->image && File::exists(public_path($row->image)) ? ($imagePath = url(asset($row->image))) : ($imagePath = asset('assets/backend/media/svg/files/blank-image.svg'));
        $div =
            '<a href=' .
            route($route, $row->id) .
            " title='" .
            $row->title .
            "'>
                <div class=\"symbol symbol-50px\"><img class=\"img-fluid\" src=" .
            $imagePath .
            "></div>
                </a>";

        return $div;
    }

    public function dataTableGetStatus($row)
    {
        if ($row->status == 1) {
            $checked = 'checked';
            $statusLabel = "<span class=\"text-success\">" . __('site.published') . '</span>';
        } else {
            $checked = '';
            $statusLabel = "<span class=\"text-danger\">" . __('site.unpublished') . '</span>';
        }
        $div = "<div class=\"form-check form-switch form-check-custom form-check-solid\"><input class=\"form-check-input UpdateStatus\" name=\"Updatetatus\" type=\"checkbox\" " . $checked . " id=\"Status" . $row->id . "\" onclick=\"UpdateStatus($row->id,'" . __($this->TRANS . '.plural') . "','$this->Tbl','" . route('UpdateStatus') . "')\" />&nbsp;" . $statusLabel . '</div>';
        return $div;
    }

    public function dataTableGetCreatedat($date)
    {
        $shortDate = \Carbon\Carbon::parse($date)->diffForHumans();
        $div = "<div class=\"font-weight-bolder text-primary mb-0\">" . \Carbon\Carbon::parse($date)->format('d/m/Y') . '</div><div class=\"text-muted\">' . '' . '</div>';
        return [
            'display' => $div,
            'timestamp' => $date->timestamp,
        ];
    }

    public function dataTableEditRecordAction($row, $route, $hide_edit = null)
    {
        $editRoute = $hide_edit == 'hide_edit' ? 'hide_edit' : route($route . '.edit', $row->id);

        return view('backend.partials.btns.edit-delete', [
            'trans' => $this->TRANS,
            'editRoute' => $editRoute,
            'destroyRoute' => route($route . '.destroy', $row->id),
            'id' => $row->id,
        ]);
    }

    public function dataTableUpdateStatus(Request $request)
    {
        if (DB::table($request->table)->find($request->id)) {
            if (
                DB::table($request->table)
                    ->where('id', $request->id)
                    ->update(['status' => $request->status])
            ) {
                $arr = ['msg' => __('site.status_updated'), 'status' => true];
            } else {
                $arr = ['msg' => 'ERROR In Update Status', 'status' => false];
            }
            return response()->json($arr);
        }
    }

    public function str_split(string $str, int $len = 1)
    {
        $arr = [];
        $length = mb_strlen($str, 'UTF-8');
        for ($i = 0; $i < $length; $i += $len) {
            $arr[] = mb_substr($str, $i, $len, 'UTF-8');
        }
        return $arr[0];
    }
}
