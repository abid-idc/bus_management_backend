<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use Illuminate\Http\Request;

class NotebookController extends Controller
{
    public function create(Request $request) {
        try {
            $data = $request->all();
            $notebook = Notebook::create($data);
            return response()->json([
                "success" => true,
                "message" => "opération a réussi",
                "data" => $notebook
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 404);
        }
    }

    public function paginatedReadAll(Request $request) {
        try {
            $data = Notebook::with("recipes")->paginate(10);
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

    public function readAll(Request $request) {
        try {
            $data = Notebook::with("recipes")->get();
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
            $object = Notebook::with("recipes")->find($request->id);
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
            $object = Notebook::find($request->id);
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
            $object = Notebook::find($request->id);
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
