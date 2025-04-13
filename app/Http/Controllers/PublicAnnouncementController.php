<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicAnnouncement;
use App\Http\Resources\PublicAnnouncementResource;
use App\Models\PublicAnnouncement;
use Illuminate\Support\Facades\DB;

class PublicAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = PublicAnnouncement::orderBy('id', 'desc')->get();

        return PublicAnnouncementResource::collection($announcements);
    }

    public function store(StorePublicAnnouncement $request)
    {
        try {
            DB::beginTransaction();
            $announcement = PublicAnnouncement::create($request->all());

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $announcement->images()->create([
                        'image' => $image,
                    ]);
                }
            }
            DB::commit();

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

    public function update(StorePublicAnnouncement $request, $Id)
    {
        try {
            DB::beginTransaction();
            $announcement = PublicAnnouncement::find($Id);
            if (! $announcement) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $announcement->update($request->all());

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $announcementImage = $announcement->images()->skip($index)->first();

                    if ($announcementImage) {
                        $announcementImage->image = $image;
                        $announcementImage->save();
                    } else {
                        $announcement->images()->create([
                            'image' => $image,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Updated SuccessFully',
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

    public function show($Id)
    {
        $announcement = PublicAnnouncement::find($Id);
        if (! $announcement) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return PublicAnnouncementResource::make($announcement);
    }

    public function delete($Id)
    {
        try {
            $announcement = PublicAnnouncement::find($Id);
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
