<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPayment;
use App\Http\Requests\PaymentsPostRequest;
use App\Http\Requests\PaymentsDeleteRequest;
use App\Jobs\DeleteIdPayment;
use Queue;
use Artisan;

class PaymentsController extends Controller
{
    public function index(Request $request){ //-- GET /payments, Untuk mendapatkan data semua payments. Gunakan pagination.

        if($request->ajax()){
            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');

            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value

            $totalRecords = DataPayment::select('count(*) as allcount')->count();
            // Fetch records
            $records = DataPayment::orderBy($columnName,$columnSortOrder)->select(['id', 'payment_name'])
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();
            foreach($records as $record){
                $id = $record->id;
                $payment_name = $record->payment_name;

                $data_arr[] = array(
                    "id" => $id,
                    "payment_name" => $payment_name,
                    "action" => "<input type='checkbox' class='delete' name='delete' value=". $id ."><label for='vehicle1'></label>",
                  );
            }
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecords,
                "aaData" => $data_arr
             );
        
             $DataPayment = json_encode($response);

        } else {
            $DataPayment = DataPayment::select(['id', 'payment_name'])->paginate(10);
        }

        return $DataPayment;

    }

    public function store(PaymentsPostRequest $request){ //-- POST /payments, Untuk membuat payment baru


        $validated = $request->validated();

        DataPayment::Create($validated);

        return response()->json([
            'message' => '200',
        ]);
    }

    public function delete(PaymentsDeleteRequest $request){// -- DELETE /payments

        $validated = $request->validated();
        //dd($validated['id']);
        foreach($validated['id'] as &$value){
            Queue::push(new DeleteIdPayment($value));
        }

        Artisan::call('queue:work --stop-when-empty');

        return response()->json([
            'message' => '200',
        ]);
    }
}
