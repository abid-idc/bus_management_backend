<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Specialty, Type, City, Company, Employee, Line, Bus, Operation, Recipe};

class StatisticsController extends Controller
{
    public function generalStatistics()
    {
        return response()->json([
            'total_specialties' => Specialty::count(),
            'total_types' => Type::count(),
            'total_cities' => City::count(),
            'total_companies' => Company::count(),
            'total_employees' => Employee::count(),
            'total_buses' => Bus::count(),
            'buses_status' => Bus::select('status', DB::raw('count(*) as total'))->groupBy('status')->get(),
            'total_lines' => Line::count(),
            'total_operations' => Operation::count(),
            'total_recipes' => Recipe::count(),
        ]);
    }

    public function employeeStatistics()
    {
        return response()->json([
            'employees_per_role' => Employee::select('role', DB::raw('count(*) as total'))->groupBy('role')->get(),
            'employees_in_operations' => DB::table('operation_employees')->count(),
        ]);
    }

    public function busStatistics()
    {
        return response()->json([
            'buses_per_status' => Bus::select('status', DB::raw('count(*) as total'))->groupBy('status')->get(),
        ]);
    }

    public function operationStatistics()
    {
        return response()->json([
            'total_operations' => Operation::count(),
            'operations_per_type' => Operation::with("type")->select('type_id', DB::raw('count(*) as total'))->groupBy('type_id')->get(),
        ]);
    }

    public function revenueStatistics()
    {
        return response()->json([
            'total_revenue' => Recipe::sum('amount'),
            'revenue_per_line' => Recipe::select('line_id', DB::raw('sum(amount) as total_revenue'))->groupBy('line_id')->get(),
            'revenue_per_bus' => Recipe::select('bus_id', DB::raw('sum(amount) as total_revenue'))->groupBy('bus_id')->get(),
        ]);
    }
}
