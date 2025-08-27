<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncement;
use App\Http\Resources\PublicAnnouncementResource;
use App\Jobs\SendPublicAnnouncementNotification;
use App\Models\Announcement;
use App\Models\DeviceToken;
use App\Models\Notification;
use App\Services\FirebaseService;
use App\Statuses\AcademicYear;
use App\Statuses\Specialization;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('id', 'desc')->get();

        return PublicAnnouncementResource::collection($announcements);
    }

    public function getAnnouncements()
    {
        $user = auth()->user();

        $academicYear = $user->academic_year;
        $specialization = $user->specialization;

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

        [$general, $targeted] = $announcements->partition(function ($announcement) {
            return $announcement->academic_year == AcademicYear::General;
        });

        return response()->json([
            'general_announcements' => PublicAnnouncementResource::collection($general),
            'targeted_announcements' => PublicAnnouncementResource::collection($targeted),
        ]);
    }

    public function store(StoreAnnouncement $request)
    {
        try {
            DB::beginTransaction();
            $announcement = Announcement::create($request->all());

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $announcement->images()->create([
                        'image' => $image,
                    ]);
                }
            }
            DB::commit();

            $tokensQuery = DeviceToken::query()
                ->join('students', 'students.id', '=', 'device_tokens.student_id');

            if ($announcement->academic_year != AcademicYear::General) {
                $tokensQuery->where('students.academic_year', $announcement->academic_year);
            }

            if ($announcement->specialization != Specialization::General) {
                $tokensQuery->where('students.specialization', $announcement->specialization);
            }

            $tokens = $tokensQuery->pluck('device_tokens.device_token')->toArray();

             Notification::create([
                'title'           => $announcement->title ?? 'إعلان جديد',
                'body'            => $announcement->description ?? '',
                'announcement_id' => $announcement->id,
                'academic_year'   => $announcement->academic_year,
                'specialization'  => $announcement->specialization,
                'tokens_count'    => count($tokens),
            ]);

            $firebase = app(FirebaseService::class);
            $firebase->BasicSendNotification(
                $announcement->title ?? 'إعلان جديد',
                $announcement->description ?? '',
                $tokens,
                ['announcement_id' => $announcement->id]
            );

            return response()->json([
                'message' => 'Created SuccessFully',
                'data' => PublicAnnouncementResource::make($announcement),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(StoreAnnouncement $request, $Id)
    {
        try {
            DB::beginTransaction();

            $announcement = Announcement::find($Id);
            if (! $announcement) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            $announcement->update($request->all());

            if ($request->has('keepImages')) {
                $keepImages = $request->input('keepImages', []);

                $announcement->images()
                    ->whereNotIn('id', $keepImages)
                    ->each(function ($image) {
                        // Storage::delete($image->image);
                        $image->delete();
                    });
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $announcement->images()->create([
                        'image' => $image,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Updated Successfully',
                'data' => PublicAnnouncementResource::make($announcement->fresh()),
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
        $announcement = Announcement::find($Id);
        if (! $announcement) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return PublicAnnouncementResource::make($announcement);
    }

    public function delete($Id)
    {
        try {
            $announcement = Announcement::find($Id);
            if (! $announcement) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $announcement->delete();

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
