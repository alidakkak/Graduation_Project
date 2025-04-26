<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobOpportunity;
use App\Http\Resources\JobOpportunityResource;
use App\Models\JobOpportunity;
use Illuminate\Support\Facades\DB;

class JobOpportunityController extends Controller
{
    public function index()
    {
        $jobOpportunities = JobOpportunity::orderBy('id', 'desc')->get();

        return JobOpportunityResource::collection($jobOpportunities);
    }

    public function store(StoreJobOpportunity $request)
    {
        try {
            DB::beginTransaction();
            $jobOpportunity = JobOpportunity::create($request->all());

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $jobOpportunity->images()->create([
                        'image' => $image,
                    ]);
                }
            }
            DB::commit();

            return response()->json([
                'message' => 'Created SuccessFully',
                'data' => JobOpportunityResource::make($jobOpportunity),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(StoreJobOpportunity $request, $Id)
    {
        try {
            DB::beginTransaction();
            $jobOpportunity = JobOpportunity::find($Id);
            if (! $jobOpportunity) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $jobOpportunity->update($request->all());

            if ($request->has('keepImages')) {
                $keepImages = $request->input('keepImages', []);

                $jobOpportunity->images()
                    ->whereNotIn('id', $keepImages)
                    ->each(function ($image) {
                        // Storage::delete($image->image);
                        $image->delete();
                    });
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $jobOpportunity->images()->create([
                        'image' => $image,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Updated SuccessFully',
                'data' => JobOpportunityResource::make($jobOpportunity),
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
        $jobOpportunity = JobOpportunity::find($Id);
        if (! $jobOpportunity) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return JobOpportunityResource::make($jobOpportunity);
    }

    public function delete($Id)
    {
        try {
            $jobOpportunity = JobOpportunity::find($Id);
            if (! $jobOpportunity) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $jobOpportunity->delete();

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

    public function switchJobIsExpired($id)
    {
        $job = JobOpportunity::find($id);
        $job->update([
           'is_expired' => ! $job->is_expired ,
        ]);
        return response()->json(['message' => 'تم التعديل بنجاح'], 200);
    }
}
