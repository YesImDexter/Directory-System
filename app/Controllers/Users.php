<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StaffModel;
use App\Models\DivisionModel;
use App\Models\CampusModel;

class Users extends BaseController
{
	public function index()
	{
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {

			$data = [];

			$searchData = $this->request->getPost('search_var');
			$filter_s = $this->request->getPost('filter_staff');
			$filter_d = $this->request->getPost('filter_division');
			$filter_c = $this->request->getPost('filter_campus');

			$staff_model = new StaffModel();
			$division_model = new DivisionModel();
			$campus_model = new CampusModel();

			if ($filter_s == "1") {
				$data['staff_array'] =  $staff_model->select('
				staff.staff_uid,
				staff.staff_name,
				staff.staff_image,
				staff.staff_position,
				staff.updated_at,

				IFNULL(division.div_name, "Unassigned") as div_name,
				IFNULL(campus.camp_name, "Unassigned") as camp_name')
					->like('staff.staff_name', $searchData)

					->join($division_model->getTable() . ' as division', 'division.div_id = staff.div_id AND division.deleted_at IS NULL', 'left')
					->join($campus_model->getTable() . ' as campus', 'campus.camp_id = division.camp_id  AND campus.deleted_at IS NULL', 'left')
					->findAll();
			}

			if ($filter_d == "1") {
				$data['division_array'] =  $division_model->select('
				division.div_id,
				division.div_name,
				division.div_image,
				division.div_desc,

				IFNULL(campus.camp_name, "Unassigned") as camp_name')
					->like('division.div_name', $searchData)

					->join($campus_model->getTable() . ' as campus', 'campus.camp_id = division.camp_id  AND campus.deleted_at IS NULL', 'left')
					->findAll();
			}

			if ($filter_c == "1") {
				$data['campus_array'] =  $campus_model->select('
				campus.camp_id,
				campus.camp_name,
				campus.camp_image')
					->like('campus.camp_name', $searchData)
					->findAll();
			}
		}

		echo view('common/header', $data);
		echo view('search');
		echo view('common/footer');
	}

	public function adminLogin()
	{
		$data = [];
		helper(['form']);

		//FOR LOGIN
		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];

			$errors = [
				'password' => [
					'validateUser' => 'Email or Password don\'t match'
				]
			];

			if ($this->validate($rules, $errors)) {
				$model = new UserModel();
				$user = $model->where('email', $this->request->getVar('email'))->first();
				$this->setUserSession($user);
				//$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('dashboard');
			} else {
				$data['validation'] = $this->validator;
			}
		}

		echo view('common/header', $data);
		echo view('login');
		echo view('common/footer');
	}


	public function staffLogin()
	{
		$data = [];
		helper(['form']);

		//FOR LOGIN
		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];

			$errors = [
				'password' => [
					'validateUser' => 'Email or Password don\'t match'
				]
			];

			if ($this->validate($rules, $errors)) {
				$model = new UserModel();
				$user = $model->where('email', $this->request->getVar('email'))->first();
				$this->setUserSession($user);
				//$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('dashboard');
			} else {
				$data['validation'] = $this->validator;
			}
		}

		echo view('common/header', $data);
		echo view('login');
		echo view('common/footer');
	}

	private function setUserSession($user)
	{
		$data = [
			'id' => $user['id'],
			'firstname' => $user['firstname'],
			'lastname' => $user['lastname'],
			'email' => $user['email'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
	}

	//---------------------------------------------------------------------

	public function register()
	{
		$data = [];
		helper(['form']);

		if ($this->request->getMethod() == 'post') {

			//Do Validations for REGISTER
			$rules = [
				'firstname' => 'required|min_length[3]|max_length[20]',
				'lastname' => 'required|min_length[3]|max_length[20]',
				'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[admin.email]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				$model = new UserModel();

				$newData = [
					'firstname' => $this->request->getVar('firstname'),
					'lastname' => $this->request->getVar('lastname'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
				];
				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('/');
			}
		}

		echo view('common/header', $data);
		echo view('register');
		echo view('common/footer');
	}

	//---------------------------------------------------------------------
}
