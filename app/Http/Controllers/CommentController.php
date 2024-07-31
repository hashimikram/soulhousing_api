<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tweet;
use App\Models\userDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tweetId = $request->input('tweet_id');
        $comment = Comment::with('user')
            ->join('user_details', 'user_details.user_id', '=', 'comments.user_id')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.*', 'user_details.image', 'users.name')
            ->where('comments.tweet_id', $tweetId)
            ->paginate(10);
        foreach ($comment as $data) {
            $data->image = image_url($data->image);
        }

        return response()->json($comment);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getComments(Request $request)
    {

        try {
            $postId = $request->params['post_id'];
            $offset = $request->params['offset'];
            Log::info('Offset: '.$offset);

            // Fetch latest comments
            $latestComments = Comment::with('user:id,name')
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
                $userDetail = UserDetail::where('user_id', $data->user_id)->first();
                if ($userDetail->image) {
                    $data->user->image = env('APP_URL').'/public/uploads/'.$userDetail->image;
                } else {
                    $data->user->image = env('APP_URL').'/public/uploads/avatar.png';
                }
                $data->user_name = $userDetail->user_name;

                // Process other data as needed
                $data->date = $data->created_at;
            }
            $totalCommentsCount = Comment::where('tweet_id', $postId)->count();
            $remainingCommentsCount = max(0, $totalCommentsCount - ($offset + $latestComments->count()));
            // Prepare response data
            $responseData = [
                'latest_comments' => $latestComments,
                'remaining_comments' => $remainingCommentsCount,
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            Log::error('Error fetching comments: '.$e->getMessage()); // Log any errors that occur
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
            'comment' => 'string|required',
        ], [
            'tweet_id.required' => 'Post Is Required For Like',
        ]);
        try {
            $timeline = Tweet::find($request->tweet_id);
            if ($timeline != null) {
                $comment = new Comment();
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
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
