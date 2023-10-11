<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService\StoringPostService;
use Illuminate\Http\Request;
use Mockery\Exception;

class PostController extends Controller
{
    public function index(){
    $posts = Post::all();
    return response()->json([
        "All Posts" => $posts
    ]);
    }
    public function store(PostRequest $request)
    {
         return (new StoringPostService())->store($request);
    }
    public function approved(){
        $posts = Post::where('status','approved')->get()->makeHidden(['status','rejected_reason']);
        return response()->json([
            "Approved Posts" => $posts
        ]);
    }
    public function showPost($postId){
        try {
            $post = Post::find($postId);
            if ($post) {
                return response()->json(["post" => $post]);
            }
                return response()->json(["message" => "this post dont found"]);

           }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }
    public function showPostApproved($postId){
        try {
            $post = Post::where('status','approved')->find($postId);
            if ($post) {
                $post->makeHidden(['status','rejected_reason']);
                return response()->json(["post" => $post]);
            }
            return response()->json(["message" =>  "This post was not found or is not approved."]);

        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }

}
