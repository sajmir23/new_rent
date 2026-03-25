<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentStatus;
use App\Support\EmptyDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class PaymentStatusesController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {

            try {

                $query = PaymentStatus::select([
                    'id',
                    "title_en as title",
                    'status',
                    'text_color',
                    'background_color',
                ]);

                return DataTables::eloquent($query)
                    ->addIndexColumn()
                    ->editColumn('title',function (PaymentStatus $payment_status){
                        return view('admin.payment_statuses.datatable.title',compact('payment_status'));
                    })
                    ->editColumn('status',function (PaymentStatus $payment_status){
                        return view('admin.payment_statuses.datatable.active',compact('payment_status'));
                    })
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('admin.payment_statuses.index');
    }

    public function search(Request $request){

        return response()->json(
            PaymentStatus::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
