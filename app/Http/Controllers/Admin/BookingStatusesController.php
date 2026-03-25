<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BookingStatus;
use App\Support\EmptyDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class BookingStatusesController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {

            try {

                $query = BookingStatus::select([
                    'id',
                    "title_en as title", // Dynamically select title
                    'status',
                    'text_color',
                    'background_color',
                ]);

                return DataTables::eloquent($query)
                    ->addIndexColumn()
                    ->editColumn('title',function (BookingStatus $lead_status){
                        return view('admin.booking_statuses.datatable.title',compact('lead_status'));
                    })
                    ->editColumn('status',function (BookingStatus $lead_status){
                        return view('admin.booking_statuses.datatable.active',compact('lead_status'));
                    })
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('admin.booking_statuses.index');
    }

    public function search(Request $request){

        return response()->json(
            BookingStatus::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
