<?php

namespace App\Controllers;

use App\Models\CampusModel;
use App\Models\DivisionModel;
use App\Models\StaffModel;

class DivisionController extends BaseController
{
  public function index()
  {
    $staff_model = new StaffModel();
    $division_model = new DivisionModel();
    $campus_model = new CampusModel();
    // IF(campus.deleted_at IS NULL, campus.camp_name, "Unassigned") as camp_name

    $data['division_array'] = $division_model
      ->select('division.*, IF(campus.deleted_at IS NULL, IF(campus.camp_id = "0", "Unassigned", campus.camp_name), "Removed") as camp_name, COUNT(IF(staff.deleted_at IS NULL, staff.div_id, NULL)) as member_count')
      ->join($staff_model->getTable() . ' as staff', 'division.div_id = staff.div_id', 'left')
      ->groupBy('division.div_id')
      ->join($campus_model->getTable() . ' as campus', 'division.camp_id = campus.camp_id', 'left')
      ->orderBy('member_count', 'desc')
      ->findAll();

    echo view("common/header", $data);
    return view('division/division-index');
    echo view("common/footer");
  }

  public function create()
  {
    $division_model = new DivisionModel();
    $campus_model = new CampusModel();

    $data['campus_array'] = $campus_model->select('camp_id, camp_name')->find();

    if ($this->request->getMethod() == 'post') {

      //PROTOTYPE USING RANDOM NAME AS AN IMAGE NAME
      $file = $this->request->getFile('img');
      if ($file->isValid()) {
        $fileExt = $file->guessExtension();
        $newIMGName = uniqid() . '.' . strval($fileExt);
      } else {
        $newIMGName = '';
      }

      $insertData = [
        //NAME FROM DATABASE ------------- NAME FROM VIEWS
        'div_name' => $this->request->getPost('d_name'),
        'div_image' => $newIMGName,
        'validate_image' =>  $file,
        'div_desc' => $this->request->getPost('d_desc'),
        'camp_id' => $this->request->getPost('d_camp'),
      ];

      //SUCCESS VALIDATION
      if ($division_model->insert($insertData)) {

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
            ->save(division_upload_path . $newIMGName);
        }

        return redirect()->to(base_url('division'))->with('status', 'Division Sucessfully Added');
      } else {
        //FAIL VALIDATION RETURNS ERROR
        $data['error_list'] = ['error_list' => $division_model->errors()];
      }
    }

    echo view('common/header', $data);
    return view('division/division-create');
    echo view('common/footer');
  }

  public function edit($id)
  {
    $division_model = new DivisionModel();
    $campus_model = new CampusModel();

    $data['division_array'] =  $division_model->select('division.*, IFNULL(division.camp_id, 0) as camp_id')
      ->find($id);

    $data['campus_array'] = $campus_model->select('camp_id, camp_name')->findAll();

    if ($this->request->getMethod() == 'post') {

      $clear_trigger = $this->request->getPost('var_clear');
      $file = $this->request->getFile('img');

      //NEW IMAGE NAME
      if ($clear_trigger == "clear") {
        $newIMGName = "";
      } else if (file_exists($file) && $file->isValid()) {
        $fileExt = $file->guessExtension();
        $newIMGName = uniqid() . '.' . strval($fileExt);
      } else {
        //SET AS OLD IMAGE NAME
        $newIMGName = $data['division_array']['div_image'];
      }

      $updateData = [
        //NAME FROM DATABASE ------------- NAME FROM VIEWS
        'div_name' => $this->request->getPost('d_name'),
        'div_image' => $newIMGName,
        'validate_image' =>  $file,
        'div_desc' => $this->request->getPost('d_desc'),
        'camp_id' => $this->request->getPost('d_camp'),
      ];

      //SUCCESS VALIDATION
      if ($division_model->update($id, $updateData)) {

        //DELETE IMAGE DIRECTORY
        if ($clear_trigger == 'clear') {
          if (is_file(division_upload_path . $data['division_array']['div_image'])) {
            unlink(division_upload_path . $data['division_array']['div_image']);
          }
          //IF ID WAS CHANGED, CHANGE NAME OF THE FILE 
        } else if ($id != $data['division_array']['div_id'] && $data['division_array']['div_image'] != ''  && file_exists($file) == FALSE) {
          rename(division_upload_path . $data['division_array']['div_image'], division_upload_path . $newIMGName);
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
          if (is_file(division_upload_path . $data['division_array']['div_image'])) {
            unlink(division_upload_path . $data['division_array']['div_image']);
          }

          //UPLOAD NEW IMAGE
          $image
            ->withFile($file)
            ->crop($widthRatio, $heightRatio,  $xOffset, $yOffset)
            ->save(division_upload_path . $newIMGName);
        }

        return redirect()->to(base_url('division'))->with('status', 'Division Sucessfully Updated');
      } else {

        //FAIL VALIDATION RETURNS ERROR
        $data['error_list'] = ['error_list' => $division_model->errors()];
      }
    }

    echo view('common/header', $data);
    return view('division/division-create');
    echo view('common/footer');
  }


  public function ajax_requests()
  {
    $action = $this->request->getVar('action');

    switch ($action) {
      case "delete_division":
        $id = $this->request->getVar('div_id');

        //SOFT DELETE STAFF FROM DATABASE
        $division_model = new DivisionModel();
        if ($division_model->delete($id)) {
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

    $data['division_array'] =  $division_model->select(
      '
    division.*,

    IFNULL(campus.camp_name, "Unassigned") as camp_name,
    campus.camp_id,
    campus.camp_desc,
    campus.camp_image'
    )
      ->join($campus_model->getTable() . ' as campus', 'campus.camp_id = division.camp_id  AND campus.deleted_at IS NULL', 'left')
      ->find($id);

    $data['staff_array'] =  $staff_model->select('
      staff.staff_uid,
      staff.staff_name,
      staff.staff_image,
      staff.staff_position,
      staff.updated_at'
    )
      ->where('div_id', $id)
      ->findALL();

    echo view('common/header', $data);
    echo view('division/division-view');
    echo view('common/footer');
  }
}
