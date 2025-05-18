<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;

class AuthController extends BaseController
{
    public function auth()
    {
        if(isset(getUserSession()['isLoggedIn'])){
            setFlash([
                'status'=>'error',
                'message'=>'First logut then go to login page',
            ]);
            return redirect()->back();
        }
        if($this->request->getVar()){
            $session = session();
            $model = new AuthModel();
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $data = $model->Auth($username);
            
            if(!is_null($data)){
                $pass = $data->password;
                $authenticatePassword = password_verify($password, $pass);
                if($authenticatePassword){
                    $session_data = [
                        'user' => $data,
                        'isLoggedIn' => TRUE
                    ];
                    setUserSession($session_data);
                    // getPrint($session_data);
                    //$userActivityModel = new UserActivity();
                    //$agent = getDeviceInfo();
                    /* $userActivityModel->insert([
                        'user_id'=>$data->user_id,
                        'institute_id'=>$data->institute_id,
                        'ip'=>$agent['ip_address'],
                        'login'=>getDbDate(),
                        'agent'=>json_encode($agent)
                    ]); */
                    setFlash([
                        'status'=>'success',
                        'message'=>'Welcome to dashboard',
                    ]);
                    return redirect()->to('portal/dashboard');
                }else{
                    setFlash([
                        'status'=>'error',
                        'message'=>'Password is incorrect.',
                    ]);
                    return redirect()->to('/portal');
                }
            }else{
                setFlash([
                    'status'=>'error',
                    'message'=>'Email or Username does not exist.',
                ]);
                return redirect()->to('/portal');
            }
        }
        return view('auth/login');
    }
    public function logout()
    {
        /* $userActivityModel = new UserActivity();
        $userActivityModel->update(['id'=>$this->getUserId() ?? NULL],[
            'logout'=>getDbDate()
        ]); */
        session()->remove('isLoggedIn');
        session()->remove('user');
        return redirect()
                ->to('/portal');
    }
}
