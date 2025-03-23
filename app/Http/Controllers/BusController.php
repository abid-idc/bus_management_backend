<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Company;
use Illuminate\Http\Request;
use PDF;

class BusController extends Controller
{

    public function create(Request $request) {
        try {
            $data = $request->all();
            Bus::create($data);
            return response()->json([
                "success" => true,
                "message" => "opération a réussi"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 404);
        }
    }

    public function readAll(Request $request) {
        try {
            $data = Bus::all();
            return response()->json([
                "success" => true,
                "data" => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => []
            ], 404);
        }
    }

    public function paginatedReadAll(Request $request) {
        try {
            $data = Bus::paginate(10);
            return response()->json([
                "success" => true,
                "data" => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => []
            ], 404);
        }
    }

    public function readById(Request $request) {
        try {
            $object = Bus::find($request->id);
            return response()->json([
                "success" => true,
                "data" => $object
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => []
            ], 404);
        }
    }

    public function readByQrCode(Request $request) {
        try {
            $object = Bus::where("qr_code", "=", $request->qrcode)->first();
            return response()->json([
                "success" => true,
                "data" => $object
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => []
            ], 404);
        }
    }

    public function update(Request $request)
    {
        try {
            $object = Bus::find($request->id);
            $data = $request->all();
            $object->update($data);
            return response()->json([
                "success" => true,
                "data" => $object
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => null,
                "message" => $e->getMessage()
            ], 404);
        }
    }

    public function delete(Request $request)
    {
        try {
            $object = Bus::find($request->id);
            if($object->delete()){
                return response()->json([
                    "success" => true,
                ]);
            }else{
                return response()->json([
                    "success" => false,
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
            ], 404);
        }
    }

    public function printBusesList(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $bus_ids = $request->bus_ids;
        $buses = Bus::query()
            ->whereIn('id', $bus_ids)
            ->with(['operations'])
            ->orderBy('created_at', 'desc')
            ->get();
        $company = Company::find(1);
        $data = [
            "buses" => $buses,
            "company" => $company
        ];
        $pdf = PDF::loadView('reports.buses.list', $data);
        return $pdf->stream('buses.pdf');
    }

    public function printBusOperations(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $bus_id = $request->bus_id;
        $operations_start_date = $request->start_date;
        $operations_end_date = $request->end_date;

        $bus = Bus::with(['operations.employees', 'operations.type', 'operations' => function ($query) use ($operations_start_date, $operations_end_date) {
            $query->whereBetween('operations.created_at', [$operations_start_date, $operations_end_date]);
        }])
            ->where('id', $bus_id)
            ->first();

        $company = Company::find(1);
        $data = [
            "bus" => $bus,
            "company" => $company,
            "start_date" => $operations_start_date,
            "end_date" => $operations_end_date,
        ];
        $pdf = PDF::loadView('reports.buses.operations', $data);
        return $pdf->stream('bus.pdf');
    }

}
