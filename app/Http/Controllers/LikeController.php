<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Tweet;
use App\Models\userDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getLikes(Request $request)
    {

        try {
            $postId = $request->params['post_id'];
            $offset =  $request->params['offset'];
            Log::info('Offset: ' . $offset);

            // Fetch latest comments
            $latestLikes  = Like::with('user:id,name')
                ->where('tweet_id', $postId)
                ->where('like_type', 'like')
                ->orderBy('id', 'DESC')
                ->offset($offset)
                ->limit(5)
                ->get();

            // Ensure $latestComments is iterable
            if (!is_iterable($latestLikes)) {
                throw new \RuntimeException('Latest Likes is not iterable');
            }

            // Process each comment
            foreach ($latestLikes as $data) {
                $userDetail = userDetail::where('user_id', $data->user_id)->first();
                if ($userDetail->image) {
                    $data->user->image = env('APP_URL') . '/public/uploads/' .  $userDetail->image;
                } else {
                    $data->user->image = env('APP_URL') . '/public/uploads/avatar.png';
                }
                $data->user_name = $userDetail->user_name;

                // Process other data as needed
                $data->date = $data->created_at;
            }
            $totalLikesCount = Like::where('tweet_id', $postId)->count();
            $remainingLikesCount = max(0, $totalLikesCount - ($offset + $latestLikes->count()));
            // Prepare response data
            $responseData = [
                'latest_likes' => $latestLikes,
                'remaining_likes' => $remainingLikesCount,
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
        'tweet_id' => 'required|exists:tweets,id',
    ], [
        'tweet_id.required' => 'Post Is Required For Like',
    ]);

    try {
        $timeline = Tweet::find($request->tweet_id);
        if ($timeline != NULL) {
            $like = Like::where('tweet_id', $request->tweet_id)
                        ->where('user_id', auth()->user()->id)
                        ->first();

            if ($like) {
                // Update the existing like
                $previous_like_type = $like->like_type;
                $like->like_type = $request->action;
                $like->save();

                // Adjust the tweet's like count based on the new like type
                if ($previous_like_type != $request->action) {
                    if ($request->action == 'like') {
                        $timeline->increment('likes', 1);
                    } elseif ($timeline->likes > 0) {
                        $timeline->decrement('likes', 1);
                    }
                }
            } else {
                // Create a new like
                $like = new Like();
                $like->tweet_id = $request->tweet_id;
                $like->like_type = $request->action;
                $like->user_id = auth()->user()->id;
                $like->save();

                if ($like->like_type == 'like') {
                    $timeline->increment('likes', 1);
                } elseif ($timeline->likes > 0) {
                    $timeline->decrement('likes', 1);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Like Done',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tweet not found',
            ], 404);
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
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
