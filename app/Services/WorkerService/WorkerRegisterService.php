<?php
namespace App\Services\WorkerService;
use App\Http\Traits\UploadTrait;
use App\Models\Worker;
use Illuminate\Support\Facades\Validator;

class WorkerRegisterService {
    use UploadTrait;
    protected $model;
    public function __construct(){
        $this->model = new Worker();
    }
    public function validation($request){
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $validator->validated();

    }
    public function store($data){
        $photo=$this->uploadOne($data['photo'],'workers');
        $worker = Worker::create(array_merge(
            $data,
            [
                'password' => bcrypt($data['password']),
                'photo'=>$photo,
            ]
        ));
        return $worker->email;
    }
    public function generateToken($email)
    {
        $token=substr(md5(random_int(0,9).$email.time()),0,32);
        $worker = $this->model->whereEmail($email)->first();
        $worker->verification_token=$token;
        $worker->save();
        return $worker;
    }
    public function sendEmail(){

    }
    public function register($request){
        $validate=$this->validation($request);
        $email=$this->store($validate);
        $worker=$this->generateToken($email);
        $this->sendEmail();
        return response()->json([
            "messege" => "account has been created please check youe email"
        ]);
    }
}

?>
