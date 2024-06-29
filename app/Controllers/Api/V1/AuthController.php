<?php

namespace App\Controllers\Api\V1;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\AuthModel;
use stdClass;

class AuthController extends BaseController
{
    public function auth()
    {
        // return $this->response->setJSON([]);
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[20]'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required'
            ]
        ];
        // print_r($this->request->getVar()); die;
        // getQuery();
        if (!$this->validate($rules)) {
            // print_r($this->validator->getErrors()); die;
            return $this->respond([
                'data' => [],
                'message' => $this->validator->getErrors(),
            ], 403);
        }
        $model = new AuthModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $model->Auth($username);
        if (!is_null($data)) {
            $pass = $data->password;
            $authenticatePassword = password_verify($password, $pass);
            if (!$authenticatePassword) {
                return $this->respond([
                    'data' => [],
                    'message' => "Invalid Password",
                ], 401);
            }
            if ($data->is_block) {
                return $this->respond([
                    'data' => [],
                    'message' => "This Account Has Been Suspended !!",
                ], 401);
            }
            
            $key = getenv('JWT_SECRET');
            $iat = time(); // current timestamp value
            $exp = $iat + 2592000; // 30days days
            // echo gmdate("Y-m-d\TH:i:s\Z", $exp);
            $payload = array(
                "user_id" => $data->id,
                "iat" => $iat, //Time the JWT issued at
                "exp" => $exp, // Expiration time of token
                "user_full_name" => $data->full_name,
                "user_name" => $data->username,
                "user_email" => $data->email,
                "user_phone" => $data->mobile
            );
            $token = JWT::encode($payload, $key, 'HS256');
            $response['token'] = $token;
            $response['token_expiry'] = $exp;
            $response['user_data'] = $data;
    
            return $this->respond([
                'data' => $response,
                'message' => "Loggedin Successfully",
            ]);
        } else {
            $response['message'] = 'Invalid Username/Email';
            $response['data'] = [];
            return $this->respond($response,403);
        }
    }


    public function getFun(){
    //    $payload = $this->request->user;

    //    return $this->respond($payload,200);
    }
}
