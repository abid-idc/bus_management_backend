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
            $data = [
                "notebook_id" => $request->input('notebook_id'),
                "current_index" => $request->input('current_index'),
                "line_id" => $request->input('line_id'),
                "bus_id" => $request->input('bus_id'),
                "start_date" => $request->input('start_date'),
                "employee_id" => $request->input('employee_id')
            ];

            $recipe = Recipe::create($data);
            $line = Line::with("depart", "arrival")->find($request->input('line_id'))->first();
            $bus = Bus::find($request->input('bus_id'));
            $employee = Employee::find($request->input('employee_id'));
            $company = Company::find(1);

            $data = [
                "line" => $line,
                "bus" => $bus,
                "employee" => $employee,
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

    public function readAll(Request $request) {
        try {
            $data = Recipe::with("bus", "employee", "notebook", "line")->get();
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
            $object = Recipe::with("bus", "employee", "notebook", "line")->find($request->id);
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

    public function accounting(Request $request)
    {
        try {
            $object = Recipe::find($request->recipe_id);

            $data = [
                "amount" => $request->input('amount'),
                "last_index" => $request->input('last_index'),
                "end_date" => $request->input('end_date'),
                "observation" => $request->input('observation')
            ];

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
            $recipe = Recipe::with("bus", "employee", "line")->find($request->input('recipe_id'));
            $line = Line::with("depart", "arrival")->find($recipe->line->id);
            $bus = Bus::find($recipe->bus->id);
            $employee = Employee::find($recipe->employee->id);
            $company = Company::find(1);

            $data = [
                "line" => $line,
                "bus" => $bus,
                "employee" => $employee,
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
