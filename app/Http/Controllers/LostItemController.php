<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Http\Requests\StoreLostItem;
use App\Http\Requests\UpdateComment;
use App\Http\Requests\UpdateLostItem;
use App\Http\Resources\CommentResource;
use App\Http\Resources\LostItemResource;
use App\Models\Comment;
use App\Models\LostItem;

class LostItemController extends Controller
{
    public function index()
    {
        $lostItem = LostItem::all();

        return LostItemResource::collection($lostItem);
    }

    public function switchStatus($id)
    {
        $lostItem = LostItem::find($id);

        if (! $lostItem) {
            return response()->json(['message' => 'LostItem not found'], 404);
        }

        $lostItem->update(['status' => ! boolval($lostItem->status)]);

        return response()->json(['message' => 'Updated SuccessFully'], 200);
    }

    public function store(StoreLostItem $request)
    {
        try {
            $lostItem = LostItem::create($request->all());

            return response()->json([
                'message' => 'Created SuccessFully',
                'data' => LostItemResource::make($lostItem),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateLostItem $request, $lostItemId)
    {
        try {
            $lostItem = LostItem::find($lostItemId);
            if (! $lostItem) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $lostItem->update($request->all());

            return response()->json([
                'message' => 'Updated SuccessFully',
                'data' => LostItemResource::make($lostItem),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($lostItemId)
    {
        $lostItem = LostItem::with([
            'comments' => function ($q) {
                $q->whereNull('parent_id')
                    ->orderBy('created_at', 'desc')
                    ->with('children');
            },
        ])->findOrFail($lostItemId);

        return LostItemResource::make($lostItem);
    }

    public function delete($lostItemId)
    {
        try {
            $lostItem = LostItem::find($lostItemId);
            if (! $lostItem) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $lostItem->delete();

            return response()->json([
                'message' => 'Deleted SuccessFully',
                'data' => LostItemResource::make($lostItem),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function addNewComment(StoreComment $request)
    {
        try {
            $studentID = auth('api_student')->id();
            $comment = Comment::create(array_merge(
                $request->all(),
                ['student_id' => $studentID]
            ));

            return response()->json([
                'message' => 'Created SuccessFully',
                'data' => CommentResource::make($comment)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateComment(UpdateComment $request, $commentId)
    {
        try {
            $comment = Comment::find($commentId);
            if (! $comment) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $comment->update($request->all());

            return response()->json([
                'message' => 'Updated SuccessFully',
                'data' => CommentResource::make($comment),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getCommentWithReplies($lostItemID)
    {
        $comments = Comment::where('lost_item_id', $lostItemID)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('created_at', 'desc')->get();

      //  $comments = $query->paginate(5);

        return CommentResource::collection($comments);
    }
}
