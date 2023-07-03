<?php

namespace App\Controllers;

use App\Models\StaffModel;
use CodeIgniter\RESTful\ResourceController;

class APIController extends ResourceController
{

    protected $format = 'json';

    public function index()
    {

         $db = \Config\Database::connect();
         $query   = $db->query('SELECT * FROM staff');
         $data = [
             'message' => 'success',
             'staff_data' => $query->getResultArray()
          ];
        return $this->respond($data, 200);
    }

    public function find($id)
    {
        
        $db = \Config\Database::connect();
        $query   = $db->query('SELECT * FROM staff WHERE staff_uid = ?', $id);
        $data = [
            'message' => 'success',
            'staff_data' => $query->getResultArray()
         ];
       return $this->respond($data, 200);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
