<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            $data = Employee::with("specialty")->get();
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
            $object = Employee::with("specialty")->find($request->id);
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

}
