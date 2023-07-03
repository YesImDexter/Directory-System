<?php

namespace App\Controllers;

use App\Models\CampusModel;
use App\Models\DivisionModel;
use App\Models\StaffModel;

class CampusController extends BaseController
{
  public function index()
  {
    $campus_model = new CampusModel();
    $division_model = new DivisionModel();

    $data['campus_array'] =  $campus_model->select('
    campus.camp_id, 
    campus.camp_name, 
    campus.camp_acronym, 
    
    COUNT(IF(division.deleted_at IS NULL, division.camp_id, NULL)) as division_count')
      ->join($division_model->getTable() . ' as division', 'division.camp_id = campus.camp_id', 'left')
      ->where('division.deleted_at', NULL)
      ->groupBy('division.camp_id')
      ->findAll();

    echo view('common/header');
    return view('campus/campus-index', $data);
    echo view('common/footer');
  }

  public function create()
  {
    $campus_model = new CampusModel();

    $data = [];

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
        'camp_name' => $this->request->getPost('c_name'),
        'camp_acronym' => $this->request->getPost('c_acronym'),
        'camp_desc' => $this->request->getPost('c_desc'),
        'camp_address' => $this->request->getPost('c_address'),
        'camp_office_no' => $this->request->getPost('c_office_no'),
        'camp_image' => $newIMGName,
        'validate_image' =>  $file,
        'camp_map_url' => $this->request->getPost('c_map'),
        'camp_website' => $this->request->getPost('c_website'),
      ];

      //SUCCESS VALIDATION
      if ($campus_model->insert($insertData)) {

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
            ->save(campus_upload_path . $newIMGName);
        }

        return redirect()->to(base_url('campus'))->with('status', 'Campus Sucessfully Added');
      } else {
        //FAIL VALIDATION RETURNS ERROR
        $data['error_list'] = ['error_list' => $campus_model->errors()];
      }
    }

    echo view('common/header', $data);
    return view('campus/campus-create');
    echo view('common/footer');
  }

  public function edit($id)
  {
    $campus_model = new CampusModel();

    $data['campus_array'] =  $campus_model->select('campus.*')
      ->find($id);

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
        $newIMGName = $data['campus_array']['camp_image'];
      }

      $updateData = [
        //NAME FROM DATABASE ------------- NAME FROM VIEWS
        'camp_name' => $this->request->getPost('c_name'),
        'camp_acronym' => $this->request->getPost('c_acronym'),
        'camp_desc' => $this->request->getPost('c_desc'),
        'camp_address' => $this->request->getPost('c_address'),
        'camp_office_no' => $this->request->getPost('c_office_no'),
        'camp_image' => $newIMGName,
        'validate_image' =>  $file,
        'camp_map_url' => $this->request->getPost('c_map'),
        'camp_website' => $this->request->getPost('c_website'),
      ];

      //SUCCESS VALIDATION
      if ($campus_model->update($id, $updateData)) {

        //DELETE IMAGE DIRECTORY
        if ($clear_trigger == 'clear') {
          if (is_file(campus_upload_path . $data['campus_array']['camp_image'])) {
            unlink(campus_upload_path . $data['campus_array']['camp_image']);
          }
          //IF ID WAS CHANGED, CHANGE NAME OF THE FILE 
        } else if ($id != $data['campus_array']['camp_id'] && $data['campus_array']['camp_image'] != ''  && file_exists($file) == FALSE) {
          rename(campus_upload_path . $data['campus_array']['camp_image'], campus_upload_path . $newIMGName);
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
          if (is_file(campus_upload_path . $data['campus_array']['camp_image'])) {
            unlink(campus_upload_path . $data['campus_array']['camp_image']);
          }

          //UPLOAD NEW IMAGE
          $image
            ->withFile($file)
            ->crop($widthRatio, $heightRatio,  $xOffset, $yOffset)
            ->save(campus_upload_path . $newIMGName);
        }

        return redirect()->to(base_url('campus'))->with('status', 'Campus Sucessfully Updated');
      } else {

        //FAIL VALIDATION RETURNS ERROR
        $data['error_list'] = ['error_list' => $campus_model->errors()];
      }
    }

    echo view('common/header', $data);
    return view('campus/campus-create');
    echo view('common/footer');
  }

  public function ajax_requests()
  {
    $action = $this->request->getVar('action');

    switch ($action) {
      case "delete_campus":
        $id = $this->request->getVar('camp_id');

        //SOFT DELETE STAFF FROM DATABASE
        $campus_model = new CampusModel();
        if ($campus_model->delete($id)) {
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

    $campus_model = new CampusModel();
    $division_model = new DivisionModel();
    $staff_model = new StaffModel();

    $data['campus_array'] =  $campus_model->select(
      'campus.*'
    )
      ->find($id);

    $data['division_array'] =  $division_model->select(
      '
      division.div_id,
      division.div_name,
      division.div_image,
      division.div_desc
      '
    )
      ->where('camp_id', $id)
      ->findALL();

    echo view('common/header', $data);
    echo view('campus/campus-view');
    echo view('common/footer');
  }
}
