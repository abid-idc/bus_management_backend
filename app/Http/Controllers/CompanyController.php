<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function read(Request $request) {
        try {
            $company = Company::find(1);
            return response()->json([
                "success" => true,
                "data" => $company
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->all();
            $disk = "public";
            $destination_path = "company/images";
            if ($request->hasFile('logo')) {
                $logoName = 'logo.' . $request->logo->getClientOriginalExtension();
                $request->file('logo')->storeAs($destination_path, $logoName, $disk);
                $data['logo'] = $destination_path . '/' . $logoName;
            }
            $company = Company::updateOrCreate(
                ['id' => 1],
                $data
            );
            return response()->json([
                "success" => true,
                "data" => $company,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
