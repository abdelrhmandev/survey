<?php
namespace App\Http\Controllers\backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Traits\Functions;
use DataTables;

/**
 * Class BaseController
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    use Functions;

 
    public function ReorderLisings(Request $request){  
        $items =  DB::table($request->table_name)->get();
        foreach ($items as $item) {
            $id = $item->id;
            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                   DB::table($request->table_name)->where('id', $id)->update(['order' =>  $order['position']]);                  
                }
            }
        }       

        $arr = ['msg' => __('question.reorder_updated'), 'status' => true];
        return response()->json($arr);

    }

        public function UpdateStatus(Request $request){                
        return $this->dataTableUpdateStatus($request);
    }

}
