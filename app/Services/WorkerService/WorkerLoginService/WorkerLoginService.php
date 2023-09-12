<?php
namespace App\Services\WorkerService\WorkerLoginService;
use Illuminate\Support\Facades\Validator;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;

class WorkerLoginService {
    protected $model;
    public function __construct()
    {
        $this->model=new Worker();
    }

    public function validation($request){
            $validator = Validator::make($request->all(), $request->rules());
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            return $validator->validated();

    }

    public function isValidData($data){
        if (!$token = auth()->guard('worker')->attempt($data)) {
            return response()->json(['error' => 'invalid data'], 401);
        }
        return $token;
    }
    public function getStatus($email){
        $worker=$this->model->whereEmail($email)->first();
        $status=$worker->status;
        if($status==0){
            return response()->json("your account is pending");
        }
        return $worker;

    }
    protected function  createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('worker')->user()
        ]);
    }
    public function login($request){
        $data=$this->validation($request);
        $token=$this->isValidData($data);
        $this->getStatus($request->email);
        return $this->createNewToken($token);


    }
}
?>
