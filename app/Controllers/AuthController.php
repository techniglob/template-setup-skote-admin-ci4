<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;

class AuthController extends BaseController
{
    public function Auth()
    {
        if(isset(getUserSession()['isLoggedIn'])){
            setFlash([
                'status'=>'error',
                'title'=>'Error',
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
                        'title'=>'Success',
                        'message'=>'Welcome to dashboard',
                    ]);
                    return redirect()->to('portal/dashboard');
                }else{
                    setFlash([
                        'status'=>'error',
                        'title'=>'Error',
                        'message'=>'Password is incorrect.',
                    ]);
                    return redirect()->to('/portal');
                }
            }else{
                setFlash([
                    'status'=>'error',
                    'title'=>'Error',
                    'message'=>'Email or Username does not exist.',
                ]);
                return redirect()->to('/portal');
            }
        }
        return view('auth/login');
    }

    public function updateProfile()
    {
        if($this->request->getVar('submit') == 'submit'){  //die('uydasutgdasuykg');

            $rules = [
                'full_name' => [
                    'label' => 'Full Name',
                    'rules' => 'required',
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|max_length[20]|is_unique[users.username,id,'. getBackUser()->id .']'
                ],
                'email' => [
                    'label' => 'E-mail',
                    'rules' => 'required|valid_email|is_unique[users.email,id,'. getBackUser()->id .']'
                ],
                'mobile' => [
                    'label' => 'Mobile',
                    'rules' => 'required|exact_length[10]'
                ]
            ]; 
            // print_r($this->request->getVar()); die;
            // getQuery();
            if(!$this->validate($rules)){
                // print_r($this->validator->getErrors()); die;
                return $this->response->setJSON([
                    'success'=>false,
                    'message'=>$this->validator->getErrors(),
                ]);
            }
            $model = new AuthModel();
            $data = [
                'full_name'=>$this->request->getVar('full_name'),
                'username'=>$this->request->getVar('username'),
                'email'=>$this->request->getVar('email'),
                'mobile'=>$this->request->getVar('mobile'),
                'updated_by'=>getBackUser()->id
            ];
            // print_r($this->request->getVar()); die;
            $profile_pic = $this->request->getFile('profile_pic');
            if(isset($profile_pic)){
                $rules = [
                    'profile_pic' => [
                        'label' => 'Profile Pic',
                        'rules' => 'uploaded[profile_pic]|max_size[profile_pic,200]|max_dims[profile_pic,350,350]|mime_in[profile_pic,image/png,image/jpeg,image/jpg]'
                    ]
                ];
                
                if(!$this->validate($rules)){
                    
                    return $this->response->setJSON([
                        'success'=>false,
                        'message'=>$this->validator->getErrors(),
                    ]);
                }
                $profile_pic = UploadFile($profile_pic, NULL, getBackUser()->profile_pic);
                $data['profile_pic'] = $profile_pic ?? 'default.png';

            } 
            if($model->update(getBackUser()->id, $data)){
                setFlash([
                    'status'=>'success',
                    'title'=>'Success',
                    'message'=>'Profile Updated Successfully',
                ]);
                $data = $model->find(getBackUser()->id);
                $session_data = [
                    'user' => $data,
                    'isLoggedIn' => TRUE
                ];
                setUserSession($session_data);
                return $this->response->setJSON([
                    'success'=>true
                ]);
            }


        }
        return view('portal/profile');
    }

    public function changePassword()
    {
        if($this->request->getVar('submit') == 'submit'){

            $rules = [
                'password' => [
                    'label' => 'Password',
                    'rules' => [
                        'required',
                        static function ($value, $data, &$error, $password) {
                            $model = new AuthModel();
                            $authData = $model->find(getBackUser()->id);
                            $authenticatePassword = password_verify($value, $authData->password);
                            if (!$authenticatePassword) {
                                $error = 'Current password does not match.';
                                return false;
                            }
                            return true;
                        },
                    ],
                ],
                'new_password' => [
                    'label' => 'New Password',
                    'rules' => 'required'
                ],
                'confirm_password' => [
                    'label' => 'Confirm Password',
                    'rules' => 'required|matches[new_password]'
                ]
            ];
            
            if(!$this->validate($rules)){
                
                return $this->response->setJSON([
                    'success'=>false,
                    'message'=>$this->validator->getErrors(),
                ]);
            }
            $model = new AuthModel();
            $data = [
                'password'=>getHash($this->request->getVar('confirm_password'))
            ];
            if($model->update(getBackUser()->id, $data)){
                setFlash([
                    'status'=>'success',
                    'title'=>'Success',
                    'message'=>'Password Change Successfully',
                ]);
                return $this->response->setJSON([
                    'success'=>true
                ]);
            }
            


        }
        return view('portal/change-password');
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
