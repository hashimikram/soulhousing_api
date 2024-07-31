<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTweetRequest;
use App\Http\Requests\UpdateTweetRequest;
use App\Models\Like;
use App\Models\Tweet;
use App\Models\User;
use App\Models\userDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $tweets = Tweet::orderBy('created_at', 'DESC')->paginate('10');

        foreach ($tweets as $data) {
            $data->total_likes = $data->likes;
            $user = User::find($data->user_id);
            $details = userDetail::where('user_id', $data->user_id)->first();
            $likeStatus = Like::where(['tweet_id' => $data->id, 'user_id' => $data->user_id])->first();
            $totalLikes = Like::join('users', 'users.id', '=', 'likes.user_id')->select('users.name', 'likes.tweet_id',
                'likes.user_id', 'likes.created_at')->where('likes.tweet_id', $data->id)->get();
            foreach ($totalLikes as $data_likes) {

                $details_like = userDetail::where('user_id', $data_likes->user_id)->first();
                if (isset($details_like)) {
                    $data_likes->user_name = $details_like->user_name;
                    $data_likes->avatar = env('APP_URL').'/public/uploads/'.$details_like->image;
                } else {
                    $data_likes->user_name = null;
                    $data_likes->avatar = null;
                }
            }
            if (isset($likeStatus)) {
                if ($likeStatus->like_type == 'like') {
                    $data->is_liked = true;
                } else {
                    $data->is_liked = false;
                }
            } else {
                $data->is_liked = false;
            }
            $filename = $data->file_name;
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
            $fileType = '';

            // Check if the file extension indicates it's an image
            $imageExtensions = array("jpg", "jpeg", "png", "gif");
            if (in_array(strtolower($fileExtension), $imageExtensions)) {
                $fileType = "image";
            } else {
                // Check if the file extension indicates it's a video
                $videoExtensions = array("mp4", "avi", "mov", "mkv");
                if (in_array(strtolower($fileExtension), $videoExtensions)) {
                    $fileType = "video";
                } else {
                    $fileType = "unknown";
                }
            }

            $data->file_type = $fileType;
            $data->file_path = env('APP_URL').'/public/'.$data->file_path;
            $data->likes = $totalLikes;
            $data->user = [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $details->user_name,
                'avatar' => env('APP_URL').'/public/uploads/'.$details->image,
            ];

            unset($data->user_id); // Remove user_id from the data object
            Log::info($tweets);
        }


        return response($tweets);
    }

    public function admin_index()
    {
        $tweets = Tweet::with('user')->orderBy('created_at', 'DESC')->paginate('10');
        return view('backend.pages.maintanance.index', compact('tweets'));
    }

    public function loadMore(Request $request)
    {
        $page = $request->input('page', 1);
        $tweets = Tweet::with('user')->orderBy('created_at', 'DESC')->paginate(5, ['*'], 'page', $page);

        $html = view('backend.pages.partials.tweets', compact('tweets'))->render();

        return response()->json([
            'html' => $html,
            'hasMorePages' => $tweets->hasMorePages(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTweetRequest $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        try {
            // Create a new Tweet instance
            $tweet = new Tweet();
            $tweet->user_id = auth()->user()->id;
            $tweet->body = $request->body;
            $fileName = null;
            $filePath = null;

            // Check if media is provided
            if ($request->media) {
                $fileData = $request->input('media');

                // Perform the regex check to validate and extract the base64 data
                if (preg_match('/^data:(\w+)\/(\w+);base64,/', $fileData, $type)) {
                    $fileData = substr($fileData, strpos($fileData, ',') + 1);
                    $fileData = base64_decode($fileData);
                    // Check if the base64 decode operation was successful
                    if ($fileData === false) {
                        return response()->json(['error' => 'Base64 decode failed'], 400);
                    }

                    // Determine the mime type and file extension
                    $mimeType = strtolower($type[1]);
                    $extension = strtolower($type[2]);
                    $fileName = uniqid().'.'.$extension;
                    Log::info('File Mime:'.$mimeType);
                    Log::info('File Extension:'.$extension);

                    // Save the file to the public storage
                    $filePath = 'uploads/'.$fileName;
                    $publicPath = public_path($filePath);

                    if (file_put_contents($publicPath, $fileData) === false) {
                        return response()->json(['error' => 'File saving failed'], 500);
                    }

                    // Verify the saved file
                    if (!file_exists($publicPath) || filesize($publicPath) === 0) {
                        return response()->json(['error' => 'File does not exist or is empty after saving'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Invalid media data'], 400);
                }
            }

            // Save the tweet with file information
            $tweet->file_name = $fileName;
            $tweet->file_path = $filePath;
            $tweet->date = now();
            $tweet->save();

            return response()->json([
                'code' => 'success',
                'message' => 'Tweet Posted',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 'false',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTweetRequest $request, Tweet $tweet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        abort_if($tweet->user->id !== auth()->id(), 403);

        return response()->json($tweet->delete(), 200);
    }

    public function give_review(Request $request)
    {
        $request->validate([
            'data_id' => 'required|exists:tweets,id',
            'review' => "required"
        ]);
        try {
            $tweet = Tweet::FindOrFail($request->data_id);
            if (isset($tweet)) {
                $tweet->comment = $request->review;
                $tweet->save();
            } else {
                return redirect()->route('maintenance.admin_index')->with('error', 'Data not Found');
            }
            return redirect()->route('maintenance.admin_index')->with('success', 'Review Added');
        } catch (\Exception $e) {
            Log::info('Maintenance Review Error'.' '.$e->getMessage());
            return redirect()->route('maintenance.admin_index')->with('error', 'Something Went Wrong');
        }
    }
}
