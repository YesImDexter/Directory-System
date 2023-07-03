<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointment';

    protected $primaryKey = "app_id";
    protected $allowedFields = [
        'app_committee',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    //  ADD TO CONTROLLER TO DISABLE ->WHERE(deleted_at = NULL);
    // $data = $yourModel->excludeDeleted(false)->find();

    protected $globalScopes = [
        'excludeDeleted' => true
    ];

    protected function excludeDeleted(bool $exclude = true)
    {
        if ($exclude) {
            $this->globalScopes['excludeDeleted'] = true;
        } else {
            unset($this->globalScopes['excludeDeleted']);
        }
        return $this;
    }

    protected $validationRules = [
        'app_committee' =>         [
            'label' => 'Appointment Title',
            'rules' => 'required',
        ],
    ];
}
