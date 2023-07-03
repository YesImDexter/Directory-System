<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\AppStaffModel;
use App\Models\StaffModel;
use App\Models\CampusModel;
use App\Models\DivisionModel;

class StaffController extends BaseController
{

  public function index()
  {
    $campus_model = new CampusModel();
    $division_model = new DivisionModel();
    $staff_model = new StaffModel();

    $data['staff_array'] =  $staff_model->select(
      '
    staff.staff_uid,
    staff.staff_name,
    staff.div_id,
    staff.staff_unit,
    
    IFNULL(division.div_name, "Unassigned") as div_name,
    IFNULL(campus.camp_name, "Unassigned") as camp_name'
    )
      ->join($division_model->getTable() . ' as division', 'division.div_id = staff.div_id AND division.deleted_at IS NULL', 'left')
      ->join($campus_model->getTable() . ' as campus', 'campus.camp_id = division.camp_id  AND campus.deleted_at IS NULL', 'left')
      ->orderBy('staff.staff_uid', 'desc') // Order by staff_uid column
      ->findAll();

    echo view('common/header');
    return view('staff/staff-index', $data);
    echo view('common/footer');
  }

  public function create()
  {
    $data['img_array'] = img_array_glob;
    $data['type_array'] = type_array_glob;
    $data['unit_array'] = unit_array_glob;
    $data['title_array'] = title_array_glob;
    $data['position_array'] = position_array_glob;

    $staff_model = new StaffModel();
    $campus_model = new CampusModel();
    $data['campus_array'] = $campus_model->findAll();

    if ($this->request->getMethod() == 'post') {

      //PROTOTYPE USING STAFF ID AS AN IMAGE NAME
      $staffID = $this->request->getPost('s_id');
      $file = $this->request->getFile('img');
      if ($file->isValid()) {
        $fileExt = $file->guessExtension();
        $newIMGName = strtoupper(strtok(strval($staffID), " ")) . '.' . strval($fileExt);
      } else {
        $newIMGName = '';
      }

      $insertData = [
        //NAME FROM DATABASE ------------- NAME FROM VIEWS
        'staff_id' => $staffID,
        'staff_name' => $this->request->getPost('s_name'),
        'div_id' => strval($this->request->getPost('s_div')),

        // 'camp_id' => $this->request->getPost('s_camp'),

        'staff_title' => $this->request->getPost('s_title'),
        'staff_position' => $this->request->getPost('s_position'),
        'staff_unit' => $this->request->getPost('s_unit'),
        'staff_type' => $this->request->getPost('s_type'),
        'validate_image' =>  $file,
        'staff_image' => $newIMGName,
        'staff_desc' => $this->request->getPost('s_desc'),
        'staff_email' => $this->request->getPost('s_email'),
        'staff_tel' => $this->request->getPost('s_tel'),
        'staff_office' => $this->request->getPost('s_office'),
        'staff_fax' => $this->request->getPost('s_fax'),
      ];

      //SUCCESS VALIDATION
      if ($staff_model->insert($insertData)) {

        //Location of The New File
        if (file_exists($file) && $file->isValid()) {

          $image = \Config\Services::image('gd');
          $info = \Config\Services::image('gd')
            ->withFile($file)
            ->getProperties(true);

          //CUT HEIGHT
          if ($info['width'] <= $info['height']) {
            $heightRatio = $info['width'];
            $widthRatio = $info['width'];

            $xOffset = 0;
            $yOffset = 0 + (($info['height'] - $heightRatio) / 2);

            //CUT WIDTH
          } else {
            $heightRatio = $info['height'];
            $widthRatio = $info['height'];

            $xOffset = 0 + (($info['width'] - $widthRatio) / 2);
            $yOffset = 0;
          }

          $image->withFile($file)
            ->crop($widthRatio, $heightRatio,  $xOffset, $yOffset)
            ->save(staff_upload_path . $newIMGName);
        }

        return redirect()->to(base_url('staff'))->with('status', 'Staff Sucessfully Added');
      } else {
        //FAIL VALIDATION RETURNS ERROR
        $data['error_list'] = ['error_list' => $staff_model->errors()];
      }
    }

    echo view('common/header', $data);
    return view('staff/staff-create');
    echo view('common/footer');
  }

  public function edit($id)
  {
    $data['img_array'] = img_array_glob;
    $data['type_array'] = type_array_glob;
    $data['unit_array'] = unit_array_glob;
    $data['title_array'] = title_array_glob;
    $data['position_array'] = position_array_glob;

    $staff_model = new StaffModel();
    $division_model = new DivisionModel();
    $campus_model = new CampusModel();

    // $data['staff_array'] = $staff_model->find($id);

    $data['staff_array'] =  $staff_model->select('staff.*, IFNULL(division.div_id, 0) as div_id, IFNULL(campus.camp_id, 0) as camp_id')
      ->join($division_model->getTable() . ' as division', 'division.div_id = staff.div_id', 'left')
      ->join($campus_model->getTable() . ' as campus', 'campus.camp_id = division.camp_id', 'left')
      ->find($id);

    $data['campus_array'] = $campus_model->select('camp_id, camp_name')->findAll();

    $uid = $data['staff_array']['staff_uid'];

    if ($this->request->getMethod() == 'post') {

      $staffID = $this->request->getPost('s_id');
      $clear_trigger = $this->request->getPost('var_clear');
      $file = $this->request->getFile('img');

      //NEW IMAGE NAME
      if ($clear_trigger == "clear") {
        $newIMGName = "";
      } else if (file_exists($file) && $file->isValid()) {
        $fileExt = $file->guessExtension();
        $newIMGName = strtoupper(strval($staffID)) . '.' . strval($fileExt);
      } else {
        //SET OLD IMAGE NAME
        $old_image_ext = substr($data['staff_array']['staff_image'], strpos($data['staff_array']['staff_image'], "."));
        $newIMGName = strtoupper(strval($staffID)) . $old_image_ext;
      }

      $updateData = [
        //NAME FROM DATABASE ------------- NAME FROM VIEWS

        'uid' => $uid,
        'staff_id' => $this->request->getPost('s_id'),
        'staff_name' => $this->request->getPost('s_name'),
        'div_id' => strval($this->request->getPost('s_div')),
        'staff_title' => $this->request->getPost('s_title'),
        'staff_position' => $this->request->getPost('s_position'),
        'staff_unit' => $this->request->getPost('s_unit'),
        'staff_type' => $this->request->getPost('s_type'),
        'validate_image' =>  $file,
        'staff_image' => $newIMGName,
        'staff_desc' => $this->request->getPost('s_desc'),
        'staff_email' => $this->request->getPost('s_email'),
        'staff_tel' => $this->request->getPost('s_tel'),
        'staff_office' => $this->request->getPost('s_office'),
        'staff_fax' => $this->request->getPost('s_fax'),
      ];

      //SUCCESS VALIDATION
      if ($staff_model->update($uid, $updateData)) {

        //DELETE IMAGE DIRECTORY
        if ($clear_trigger == 'clear') {
          if (is_file(staff_upload_path . $data['staff_array']['staff_image'])) {
            unlink(staff_upload_path . $data['staff_array']['staff_image']);
          }
          //IF ID WAS CHANGED, CHANGE NAME OF THE FILE 
        } else if ($staffID != $data['staff_array']['staff_id'] && $data['staff_array']['staff_image'] != ''  && file_exists($file) == FALSE) {
          rename(staff_upload_path . $data['staff_array']['staff_image'], staff_upload_path . $newIMGName);
        }

        //LOCATION OF THE NEW FILE
        if (file_exists($file) && $file->isValid()) {

          $image = \Config\Services::image('gd');
          $info = \Config\Services::image('gd')
            ->withFile($file)
            ->getProperties(true);

          //CUT HEIGHT
          if ($info['width'] <= $info['height']) {
            $heightRatio = $info['width'];
            $widthRatio = $info['width'];

            $xOffset = 0;
            $yOffset = 0 + (($info['height'] - $heightRatio) / 2);

            //CUT WIDTH
          } else {
            $heightRatio = $info['height'];
            $widthRatio = $info['height'];

            $xOffset = 0 + (($info['width'] - $widthRatio) / 2);
            $yOffset = 0;
          }

          //DELETE OLD IMAGE
          if (is_file(staff_upload_path . $data['staff_array']['staff_image'])) {
            unlink(staff_upload_path . $data['staff_array']['staff_image']);
          }

          //UPLOAD NEW IMAGE
          $image
            ->withFile($file)
            ->crop($widthRatio, $heightRatio,  $xOffset, $yOffset)
            ->save(staff_upload_path . $newIMGName);
        }

        return redirect()->to(base_url('staff'))->with('status', 'Staff Sucessfully Updated');
      } else {

        //FAIL VALIDATION RETURNS ERROR
        $data['error_list'] = ['error_list' => $staff_model->errors()];
      }
    }

    echo view('common/header', $data);
    return view('staff/staff-create');
    echo view('common/footer');
  }

  public function ajax_requests()
  {
    $action = $this->request->getVar('action');

    switch ($action) {
      case "get_division":
        $camp_id = $this->request->getVar('camp_id');
        $div_id_set = $this->request->getVar('div_id_set');

        // GET THE DIVISION ID LISTED UNDER THE CAMP
        $div_model = new DivisionModel(); 
        $division_list = $div_model->where('camp_id', $camp_id)->select('div_id, div_name')->findAll();

        $data_array = array($div_id_set, $division_list);
        echo json_encode($data_array);
        break;

      case "get_campus_no":
        $camp_id = $this->request->getVar('camp_id');

        // GET THE DIVISION ID LISTED UNDER THE CAMP
        $campus_model = new CampusModel();
        $campus_office_no = $campus_model->where('camp_id', $camp_id)->findColumn('camp_office_no');

        echo json_encode($campus_office_no);
        break;

      case "delete_staff":
        $uid = $this->request->getVar('staff_uid');

        //SOFT DELETE STAFF FROM DATABASE
        $staff_model = new StaffModel();
        if ($staff_model->delete($uid)) {
          echo json_decode(true);
        } else {
          echo json_decode(false);
        }

        break;

      default:
    }
  }

  public function view($id)
  {
    $staff_model = new StaffModel();
    $division_model = new DivisionModel();
    $campus_model = new CampusModel();


    $data['staff_array'] =  $staff_model->select(
      '
    staff.*,

    IFNULL(division.div_name, "Unassigned") as div_name,
    division.div_image,
    division.div_desc,

    IFNULL(campus.camp_name, "Unassigned") as camp_name,
    campus.camp_id,
    campus.camp_desc,
    campus.camp_office_no,
    campus.camp_image'
    )
      ->join($division_model->getTable() . ' as division', 'division.div_id = staff.div_id AND division.deleted_at IS NULL', 'left')
      ->join($campus_model->getTable() . ' as campus', 'campus.camp_id = division.camp_id  AND campus.deleted_at IS NULL', 'left')
      ->find($id);

    $app_staff_model = new AppStaffModel();
    $appointment_model = new AppointmentModel();

    $data['appointment_array'] =  $app_staff_model->where('staff_uid', $id)
      ->select('
      app_staff_link.*,
      appointment.app_committee
      ')

      ->join($appointment_model->getTable() . ' as appointment', 'appointment.app_id = app_staff_link.app_id', 'inner')
      ->where('app_staff_link.deleted_at', NULL)
      ->findAll();

    echo view('common/header', $data);
    echo view('staff/staff-view');
    echo view('common/footer');
  }
}
