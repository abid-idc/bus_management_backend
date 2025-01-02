<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Line;
use App\Models\Recipe;
use Illuminate\Http\Request;
use PDF;

class RecipeController extends Controller
{
    public function create(Request $request) {
        try {
            $recipe = Recipe::create($request->all());
            return response()->json([
                "success" => true,
                "data" => $recipe
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
            $data = Recipe::with("bus", "accountant", "line", "driver", "receiver")->get();
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
            $data = Recipe::with("bus", "accountant", "line", "driver", "receiver")->paginate(10);
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
            $object = Recipe::with("bus", "accountant", "line", "driver", "receiver")->find($request->id);
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
            $object = Recipe::find($request->id);
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
            $object = Recipe::find($request->id);
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

    public function printRecipe(Request $request) {
        try {
            $recipe = Recipe::with("bus", "accountant", "line", "driver", "receiver")->find($request->input('recipe_id'));
            $line = Line::with("depart", "arrival")->find($recipe->line->id);
            $bus = Bus::find($recipe->bus->id);
            $driver = Employee::find($recipe->driver->id);
            $receiver = Employee::find($recipe->receiver->id);
            $company = Company::find(1);

            $data = [
                "line" => $line,
                "bus" => $bus,
                "driver" => $driver,
                "receiver" => $receiver,
                "recipe" => $recipe,
                "company" => $company
            ];

            $pdf = PDF::loadView('reports.recipes.recipe', $data);
            return $pdf->stream('recipe.pdf');
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 404);
        }
    }
}
