<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Announcement;
use App\Statuses\AcademicYear;
use App\Statuses\Specialization;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $student = auth("api_student")->user();

        $academicYear = $student->academic_year;
        $specialization = $student->specialization;

        $announcements = Announcement::where(function ($query) use ($academicYear, $specialization) {
            $query
                ->orWhere(function ($q) {
                    $q->where('academic_year', AcademicYear::General);
                })
                ->orWhere(function ($q) use ($academicYear) {
                    $q->where('academic_year', $academicYear)
                        ->where('specialization', Specialization::General);
                })
                ->orWhere(function ($q) use ($academicYear, $specialization) {
                    $q->where('academic_year', $academicYear)
                        ->where('specialization', $specialization);
                });
        })->latest()->get();
        return NotificationResource::collection($announcements);
    }
}
