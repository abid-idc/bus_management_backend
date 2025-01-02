<?php

namespace App\Http\Controllers;

use App\Models\Control;
use Illuminate\Http\Request;

class ControlController extends Controller
{
    public function create(Request $request) {
        try {
            $data = $request->all();
            Control::create($data);
            return response()->json([
                "success" => true,
                "message" => "opération a réussi",
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
            $data = Control::with("bus", "driver", "controller", "receiver", "line")->get();
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
            $data = Control::with("bus", "driver", "controller", "receiver", "line")->paginate(10);
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
            $object = Control::with("bus", "driver", "controller", "receiver", "line")->find($request->id);
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
            $object = Control::find($request->id);
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
            $object = Control::find($request->id);
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
}
