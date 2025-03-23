<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PDF;

class EmployeeController extends Controller
{
    public function create(Request $request) {
        try {
            $data = $request->all();
            $data["password"] = Hash::make($request->password);

            $disk = "public";
            $destination_path = "images/employees";
            if ($request->hasFile('image')) {
                $imageName = $request->name . '.' . $request->image->getClientOriginalExtension();
                $request->file('image')->storeAs($destination_path, $imageName, $disk);
                $data['image'] = $destination_path . '/' . $imageName;
            } else {
                $data['image'] = env('DEFAULT_IMAGE') ?? null;
            }

            Employee::create($data);
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
            $data = Employee::with("specialty", "operations", "controls", "accountants")->get();
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

    public function readAllByRole(Request $request) {
        try {
            $data = Employee::with("specialty", "operations", "controls", "accountants")
                ->where("role", '=', $request->role)
                ->get();
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
            $data = Employee::with("specialty", "operations", "controls", "accountants")->paginate(10);
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

    public function readAllRoles() {
        return response()->json([
            "success" => true,
            "data" => [
                'user', 'admin', 'consultant',
                'driver', 'receiver', 'controller',
                'accountant', 'workshop_responsible',
                'intervener'
            ]
        ]);
    }

    public function paginatedReadAllByRole(Request $request) {
        $data = Employee::with("specialty", "operations", "controls", "accountants")
            ->where("role", '=', $request->role)
            ->paginate(10);

        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }

    public function readById(Request $request) {
        try {
            $object = Employee::with("specialty", "operations", "controls", "accountants")->find($request->id);
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
            $object = Employee::find($request->id);

            $data = $request->all();

            $disk = "public";
            $destination_path = "images/employees";
            if ($request->hasFile('image')) {
                $imageName = $request->name . '.' . $request->image->getClientOriginalExtension();
                $request->file('image')->storeAs($destination_path, $imageName, $disk);
                $data['image'] = $destination_path . '/' . $imageName;
            }

            if($request->has("password")) {
                $data["password"] = Hash::make($request->password);
            }

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
            $object = Employee::find($request->id);
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

    public function login(Request $request) {
        try {

            $person = Employee::where(
                'phone_number', $request->phone_number
            )->first();

            if (!$person || !Hash::check($request->password, $person->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $token = $person->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'employee' => $person
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => null,
                "message" => $e->getMessage()
            ], 404);
        }
    }

    public function printEmployeesList(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $employee_ids = $request->employee_ids;
        $employees = Employee::query()
            ->whereIn('id', $employee_ids)
            ->with(['specialty', 'operations'])
            ->orderBy('created_at', 'desc')
            ->get();
        $company = Company::find(1);
        $data = [
            "employees" => $employees,
            "company" => $company
        ];
        $pdf = PDF::loadView('reports.employees.list', $data);
        return $pdf->stream('employees.pdf');
    }

    public function printEmployeeOperations(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $employee_id = $request->employee_id;
        $operations_start_date = $request->start_date;
        $operations_end_date = $request->end_date;

        $employee = Employee::with(['specialty', 'operations.bus', 'operations.type', 'operations' => function ($query) use ($operations_start_date, $operations_end_date) {
            $query->whereBetween('operations.created_at', [$operations_start_date, $operations_end_date]);
        }])
            ->where('id', $employee_id)
            ->first();

        $company = Company::find(1);
        $data = [
            "employee" => $employee,
            "company" => $company,
            "start_date" => $operations_start_date,
            "end_date" => $operations_end_date,
        ];
        $pdf = PDF::loadView('reports.employees.operations', $data);
        return $pdf->stream('employee.pdf');
    }

    public function printEmployeeControls(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $employee_id = $request->employee_id;
        $controls_start_date = $request->start_date;
        $controls_end_date = $request->end_date;

        $employee = Employee::with(['specialty', 'controls.bus', 'controls.line', 'controls.line.depart', 'controls.line.arrival', 'controls' => function ($query) use ($controls_start_date, $controls_end_date) {
            $query->whereBetween('controls.created_at', [$controls_start_date, $controls_end_date]);
        }])
            ->where('id', $employee_id)
            ->first();

        $company = Company::find(1);
        $data = [
            "employee" => $employee,
            "company" => $company,
            "start_date" => $controls_start_date,
            "end_date" => $controls_end_date,
        ];
        $pdf = PDF::loadView('reports.employees.controls', $data);
        return $pdf->stream('employee.pdf');
    }

}
