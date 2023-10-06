<?php
namespace App\Services\WorkerService;
use App\Http\Traits\UploadTrait;
use App\Mail\VerificationEmail;
use App\Models\Worker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;
use Illuminate\Support\Facades\DB;

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
    public function sendEmail($worker){
        Mail::to($worker->email)->send(new VerificationEmail($worker));
    }
    public function register($request){
        try {
            DB::beginTransaction();
            $validate=$this->validation($request);
            $email=$this->store($validate);
            $worker=$this->generateToken($email);
            $this->sendEmail($worker);
            DB::commit();
            return response()->json([
                "messege" => "account has been created please check youe email"
            ]);
        }
        catch (Exception $ex){
            DB::rollBack();
            return $ex->getMessage();

        }

    }
}

?>

