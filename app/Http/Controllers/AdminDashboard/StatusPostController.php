<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusPostRequest;
use App\Models\Post;
use App\Notifications\AdminPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
class StatusPostController extends Controller
{
    public function changeStatus(StatusPostRequest $request) {
        $post = Post::find($request->post_id);
            $post->update(['status' => $request->status,
            'rejected_reason' => $request->rejected_reason]);
        Notification::send($post->worker,new AdminPost($post->worker,$post));
        return response()->json([
            "message" => "done change status post"
        ]);

    }

}
