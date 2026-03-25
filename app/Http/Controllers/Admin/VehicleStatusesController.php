<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\VehicleStatus;
use App\Support\EmptyDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class VehicleStatusesController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {

            try {

                $query = VehicleStatus::select([
                    'id',
                    "title_en as title",
                    'status',
                    'text_color',
                    'background_color',
                ]);

                return DataTables::eloquent($query)
                    ->addIndexColumn()
                    ->editColumn('title',function (VehicleStatus $vehicle_status){
                        return view('admin.vehicle_statuses.datatable.title',compact('vehicle_status'));
                    })
                    ->editColumn('status',function (VehicleStatus $vehicle_status){
                        return view('admin.vehicle_statuses.datatable.active',compact('vehicle_status'));
                    })
                    ->make(true);

            }catch (Exception $e) {
                report($e);
                return EmptyDatatable::toJson();
            }
        }

        return view('admin.vehicle_statuses.index');
    }

    public function search(Request $request){

        return response()->json(
            VehicleStatus::search(
                $request->get('keyword'),
                $request->get('id'),
            )->get()->append(['label'])
        );
    }
}
