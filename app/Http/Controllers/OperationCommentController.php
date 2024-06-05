<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOperationCommentRequest;
use App\Http\Requests\UpdateOperationCommentRequest;
use App\Models\Like;
use App\Models\Operation;
use App\Models\userDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\OperationComment;

class OperationCommentController extends Controller
{
     public function getComments(Request $request)
{

    try {
        $postId = $request->params['post_id'];
        $offset =  $request->params['offset'];
        Log::info('Offset: ' . $offset);
        
        // Fetch latest comments
        $latestComments = OperationComment::with('user:id,name')
            ->where('tweet_id', $postId)
            ->orderBy('id', 'DESC')
            ->offset($offset)
            ->limit(5)
            ->get();
        
        // Ensure $latestComments is iterable
        if (!is_iterable($latestComments)) {
            throw new \RuntimeException('Latest comments is not iterable');
        }
        
        // Process each comment
        foreach ($latestComments as $data) {
            $userDetail = userDetail::where('user_id', $data->user_id)->first();
            if ($userDetail->image) {
                $data->user->image = env('APP_URL') . '/public/uploads/' .  $userDetail->image;
            } else {
                $data->user->image = env('APP_URL') . '/public/uploads/avatar.png';
            }
                        $data->user_name = $userDetail->user_name;

            // Process other data as needed
            $data->date=$data->created_at;
        }
             $totalCommentsCount = OperationComment::where('tweet_id', $postId)->count();
        $remainingCommentsCount = max(0, $totalCommentsCount - ($offset + $latestComments->count()));
        // Prepare response data
        $responseData = [
            'latest_comments' => $latestComments,
            'remaining_comments'=>$remainingCommentsCount,
        ];
        
        return response()->json($responseData);
    } catch (\Exception $e) {
        Log::error('Error fetching comments: ' . $e->getMessage()); // Log any errors that occur
        // Handle the error gracefully, perhaps by returning a suitable response
        return response()->json(['error' => 'Failed to fetch comments'], 500);
    }
}




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tweet_id' => 'required|exists:operations,id',
            'comment' => 'string|required',
        ], [
            'tweet_id.required' => 'Post Is Required For Like',
        ]);
        try {
            $timeline = Operation::find($request->tweet_id);
            if ($timeline != NULL) {
                $comment = new OperationComment();
                $comment->tweet_id = $request->tweet_id;
                $comment->user_id = auth()->user()->id;
                $comment->comment = $request->comment;
                $comment->save();
                $timeline->increment('comments', 1);
                return response()->json([
                    'success' => true,
                    'message' => 'Comment Posted',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => [],
                ], 200);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OperationComment $operationComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OperationComment $operationComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOperationCommentRequest $request, OperationComment $operationComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperationComment $operationComment)
    {
        //
    }
}
