<?php

namespace App\Controllers;

use App\Models\UserModel;

class DashBoard extends BaseController
{
    public function index()
    {
        $data = [];

        echo view("common/header", $data);
        echo view("dashboard");
        echo view("common/footer");
    }

    //ACCESS PROFILE
    public function profile()
    {
        $data = [];
        helper(['form']);
        $model = new UserModel();

        if ($this->request->getMethod() == 'post') {
            //Validations for profile
            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
            ];

            if ($this->request->getPost('password') != '') {
                $rules['password'] = 'required|min_length[8]|max_length[255]';
                $rules['password_confirm'] = 'matches[password]';
            }


            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {

                $newData = [
                    'id' => session()->get('id'),
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                ];
                if ($this->request->getPost('password') != '') {
                    $newData['password'] = $this->request->getPost('password');
                }
                $model->save($newData);

                session()->setFlashdata('success', 'Successfuly Updated');
                return redirect()->to('/profile');
            }
        }

        //FOR STARTIG SESSIONS
        $data['user'] = $model->where('id', session()->get('id'))->first();
        echo view('common/header', $data);
        echo view('profile');
        echo view('common/footer');
    }

    public function staff()
    {
        return redirect()->to('/StaffController/index');
    }

    public function appointment()
    {
        return redirect()->to('/AppointmentController/index');
    }

    public function division()
    {
        return redirect()->to('/DivisionController/index');
    }

    public function campus()
    {
        return redirect()->to('/CampusController/index');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
