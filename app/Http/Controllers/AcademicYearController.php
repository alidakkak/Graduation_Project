<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcademicYear;
use App\Http\Resources\AcademicYearResource;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::all();

        return AcademicYearResource::collection($academicYears);
    }

    public function store(StoreAcademicYear $request)
    {
        try {
            DB::beginTransaction();

            $academicYear = AcademicYear::create($request->all());

            $semesters = [
                ['academic_year_id' => $academicYear->id, 'semester' => '1'],
                ['academic_year_id' => $academicYear->id, 'semester' => '2'],
            ];

            foreach ($semesters as $semester) {
                Semester::create($semester);
            }

            DB::commit();

            return response()->json([
                'message' => 'Created Successfully with both semesters.',
                'data' => AcademicYearResource::make($academicYear),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($Id)
    {
        $AcademicYear = AcademicYear::find($Id);
        if (! $AcademicYear) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return AcademicYearResource::make($AcademicYear);
    }

    public function delete($Id)
    {
        try {
            $AcademicYear = AcademicYear::find($Id);
            if (! $AcademicYear) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $AcademicYear->delete();

            return response()->json([
                'message' => 'Deleted SuccessFully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
