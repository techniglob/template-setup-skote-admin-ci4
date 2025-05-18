<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;
class ProfileController extends BaseController
{
    public function updateProfile()
    {
        if ($this->request->getVar('submit') == 'submit') {

            $rules = [
                'full_name' => [
                    'label' => 'Full Name',
                    'rules' => 'required',
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|max_length[20]|is_unique[users.username,id,' . getBackUser()->id . ']'
                ],
                'email' => [
                    'label' => 'E-mail',
                    'rules' => 'required|valid_email|is_unique[users.email,id,' . getBackUser()->id . ']'
                ],
                'mobile' => [
                    'label' => 'Mobile',
                    'rules' => 'required|exact_length[10]'
                ]
            ];
            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $this->validator->getErrors(),
                ]);
            }
            $model = new AuthModel();
            $data = [
                'full_name' => $this->request->getVar('full_name'),
                'username' => $this->request->getVar('username'),
                'email' => $this->request->getVar('email'),
                'mobile' => $this->request->getVar('mobile'),
                'updated_by' => getBackUser()->id
            ];

            $profile_pic = $this->request->getFile('profile_pic');
            if (isset($profile_pic)) {
                $rules = [
                    'profile_pic' => [
                        'label' => 'Profile Pic',
                        'rules' => 'uploaded[profile_pic]|max_size[profile_pic,200]|max_dims[profile_pic,350,350]|mime_in[profile_pic,image/png,image/jpeg,image/jpg]'
                    ]
                ];

                if (!$this->validate($rules)) {

                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $this->validator->getErrors(),
                    ]);
                }
                $profile_pic = UploadFile($profile_pic, NULL, getBackUser()->profile_pic);
                $data['profile_pic'] = $profile_pic ?? 'default.png';
            }
            if ($model->update(getBackUser()->id, $data)) {
                setFlash([
                    'status' => 'success',
                    'message' => 'Profile Updated Successfully',
                ]);
                $data = $model->find(getBackUser()->id);
                $session_data = [
                    'user' => $data,
                    'isLoggedIn' => TRUE
                ];
                setUserSession($session_data);
                return $this->response->setJSON([
                    'success' => true
                ]);
            }
        }
        return portalView('profile/profile');
    }

    public function changePassword()
    {
        if ($this->request->getVar('submit') == 'submit') {

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

            if (!$this->validate($rules)) {

                return $this->response->setJSON([
                    'success' => false,
                    'message' => $this->validator->getErrors(),
                ]);
            }
            $model = new AuthModel();
            $data = [
                'password' => getHash($this->request->getVar('confirm_password'))
            ];
            if ($model->update(getBackUser()->id, $data)) {
                setFlash([
                    'status' => 'success',
                    'message' => 'Password Change Successfully',
                ]);
                return $this->response->setJSON([
                    'success' => true
                ]);
            }
        }
        return portalView('profile/change-password');
    }
}
