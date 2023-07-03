<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\AppStaffModel;
use App\Models\CampusModel;
use App\Models\DivisionModel;
use App\Models\StaffModel;

class AppointmentController extends BaseController
{

    public function index()
    {
        $appointment_model = new AppointmentModel();
        $app_staff_model = new AppStaffModel();
        $staff_model = new StaffModel();

        $data['appointment_array'] =  $appointment_model->select('appointment.*, COUNT(app_staff_link.app_id) as member_count')
            ->join($app_staff_model->getTable() . ' as app_staff_link', 'appointment.app_id = app_staff_link.app_id', 'left')
            ->join($staff_model->getTable() . ' as staff', 'staff.staff_uid = app_staff_link.staff_uid', 'left')
            ->where('staff.deleted_at', NULL)
            ->where('app_staff_link.deleted_at', NULL)

            ->groupBy('appointment.app_id')
            ->findAll();

        echo view('common/header');
        return view('appointment/appointment-index', $data);
        echo view('common/footer');
    }

    public function create()
    {
        $data = [];
        $appointment_model = new AppointmentModel();
        $data['appointment_array'] = ['app_id' => NULL]; //REMOVE IF ELSE FROM VIEWS

        if ($this->request->getMethod() == 'post') {
            $insertData = [
                //NAME FROM DATABASE ------------- NAME FROM VIEWS
                'app_committee' => $this->request->getPost('a_committee'),
            ];

            if ($appointment_model->insert($insertData) == TRUE) {
                return redirect()->to(base_url('appointment'))->with('status', 'Appointment Sucessfully Added');
            } else {
                //FAIL VALIDATION RETURNS ERROR
                $data['error_list'] = ['error_list' => $appointment_model->errors()];
            }
        }

        echo view('common/header', $data);
        return view('appointment/appointment-create');
        echo view('common/footer');
    }

    public function edit($id)
    {
        $appointment_model = new AppointmentModel();
        $data['appointment_array'] = $appointment_model->find($id);

        if ($this->request->getMethod() == 'post') {

            $updateData = [
                //NAME FROM DATABASE ------------- NAME FROM VIEWS
                'app_committee' => $this->request->getPost('a_committee'),
            ];

            if ($appointment_model->update($id, $updateData)) {
                return redirect()->to(base_url('appointment-view/' . $id))->with('status', 'Appointment Sucessfully Updated');
            } else {
                //FAIL VALIDATION RETURNS ERROR
                $data['error_list'] = ['error_list' => $appointment_model->errors()];
            }
        }

        echo view('common/header', $data);
        return view('appointment/appointment-create');
        echo view('common/footer');
    }

    public function view($id)
    {
        $appointment_model = new AppointmentModel();
        $staff_model = new StaffModel();
        $division_model = new DivisionModel();
        $campus_model = new CampusModel();
        $app_staff_model = new AppStaffModel();

        $data['appointment_array'] = $appointment_model->find($id);

        $data['staff_array'] =  $app_staff_model->where('app_id', $id)
            ->select('app_staff_link.*, staff.staff_uid, staff.staff_name, staff.div_id,
        IFNULL(division.camp_id, 0) as camp_id,
        IFNULL(campus.camp_name, "Unassigned") as camp_name')

            ->join($staff_model->getTable() . ' as staff', 'staff.staff_uid = app_staff_link.staff_uid', 'inner')
            ->join($division_model->getTable() . ' as division', 'staff.div_id = division.div_id', 'left')
            ->join($campus_model->getTable() . ' as campus', 'division.camp_id = campus.camp_id', 'left')

            ->where('staff.deleted_at', NULL)

            ->findAll();

        echo view('common/header',  $data);
        return view('appointment/appointment-view');
        echo view('common/footer');
    }

    public function assign($id)
    {
        $data['app_position_array'] = app_position_array_glob;

        $appointment_model = new AppointmentModel();
        $data['appointment_array'] = $appointment_model->find($id);

        $appstaff_model = new AppStaffModel();
        $staff_model = new StaffModel();

        $data['staff_array'] = $staff_model->select('staff.staff_uid, staff.staff_name')
            ->where('staff.deleted_at', NULL)
            ->whereNotIn('staff.staff_uid', function ($query) use ($appstaff_model, $id) {
                $query->select('staff_uid')
                    ->from($appstaff_model->getTable())
                    ->where('app_staff_link.app_id =', $id)
                    ->where('app_staff_link.deleted_at', NULL);
            })
            ->findAll();

        if ($this->request->getMethod() == 'post') {

            $insertData = [
                //NAME FROM DATABASE ------------- NAME FROM VIEWS
                'app_id' => $id,
                'staff_uid' => $this->request->getPost('s_uid'),
                'app_position' => $this->request->getPost('a_position'),
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
            ];

            if ($appstaff_model->insert($insertData)) {
                return redirect()->to(base_url('appointment-view/' . $id))->with('status', 'Staff Sucessfully Assigned');
            } else {
                //FAIL VALIDATION RETURNS ERROR
                $data['error_list'] = ['error_list' => $appstaff_model->errors()];
            }
        }

        echo view('common/header',  $data);
        return view('appointment/appointment-assign');
        echo view('common/footer');
    }

    public function reassign($id)
    {
        $data['app_position_array'] = app_position_array_glob;

        $appstaff_model = new AppStaffModel();
        $db = \Config\Database::connect();
        $data['appstaff_array'] =  $appstaff_model->where('app_staff_id', $id)->select('app_staff_id, app_id')->first();

        $query   = $db->query('SELECT * FROM app_staff_link INNER JOIN staff ON app_staff_link.staff_uid = staff.staff_uid  WHERE app_staff_link.app_staff_id=?', $id);
        $data['staff_array'] = $query->getResultArray();

        if ($this->request->getMethod() == 'post') {

            $updateData = [
                //NAME FROM DATABASE ------------- NAME FROM VIEWS
                'app_position' => $this->request->getPost('a_position'),
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
            ];

            if ($appstaff_model->update($id, $updateData)) {
                return redirect()->to(base_url('appointment-view/' . $data['appstaff_array']['app_id']))->with('status', 'Staff Sucessfully Re-assigned');
            } else {
                //FAIL VALIDATION RETURNS ERROR
                $data['error_list'] = ['error_list' => $appstaff_model->errors()];
            }
        }

        echo view('common/header', $data);
        return view('appointment/appointment-reassign');
        echo view('common/footer');
    }

    public function ajax_requests()
    {
        $action = $this->request->getVar('action');

        switch ($action) {

            case "remove_appointment":
                $app_staff_id = $this->request->getVar('app_staff_id');

                //SOFT DELETE STAFF FROM APPOINTMENT
                $app_staff_model = new AppStaffModel();
                if ($app_staff_model->delete($app_staff_id)) {
                    echo json_decode(true);
                } else {
                    echo json_decode(false);
                }

                break;

            case "delete_appointment":
                $app_id = $this->request->getVar('app_id');

                //SOFT DELETE STAFF FROM APPOINTMENT
                $appointment_model = new AppointmentModel();
                if ($appointment_model->delete($app_id)) {
                    echo json_decode(true);
                } else {
                    echo json_decode(false);
                }

                break;

            default:
        }
    }
}
