<?php
namespace App\Services\PostService;

use App\Http\Traits\UploadTrait;
use App\Models\Admin;
use App\Models\Post;
use App\Models\PostPhoto;
use App\Notifications\AdminPost;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
class StoringPostService {
    use UploadTrait;
    protected $model;
    public function __construct()
    {
        $this->model = new Post();
    }
    public function storePost($request)
    {
        $data = $request->except('photos');
        $data['worker_id']=auth()->guard('worker')->id();
        $post = Post::create($data);
        return $post;

    }
    public function storePhoto($request,$postId) {
        $photo = $this->uploadOne($request->file('photos'), 'posts');
        $postPhoto = new PostPhoto();
        $postPhoto->post_id = $postId;
        $postPhoto->photo = $photo;
        $postPhoto->save();

    }
    public function sendAdminNotification($post) {
        $admins = Admin::get();
        Notification::send($admins, new AdminPost(auth()->guard('worker')->user(),$post));

    }
    public function store($request) {

        try {
            DB::beginTransaction();
            $post = $this->storePost($request);
            if ($request->hasfile('photos')){
                $storephoto = $this->storePhoto($request, $post->id);
            }
            $this->sendAdminNotification($post);
            DB::commit();

            return response()->json(
                ["message" => "the post has been created successful"]
            );
        }
        catch (Exception $ex){
            DB::rollback();
            return $ex->getMessage();
        }
    }
}
?>
