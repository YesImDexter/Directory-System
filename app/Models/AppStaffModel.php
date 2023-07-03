<?php

namespace App\Models;

use CodeIgniter\Model;

class AppStaffModel extends Model
{
    protected $table = 'app_staff_link';
    protected $primaryKey = "app_staff_id";
    protected $allowedFields = [
        'app_id',
        'staff_uid',
        'app_position',
        'start_date',
        'end_date',
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
        'staff_uid' =>         [
            'label' => 'Staff',
            'rules' => 'required',
        ],

        'app_position' =>         [
            'label' => 'Committee Position',
            'rules' => 'required|in_list[Unassigned, Board Members, Treasurer, Secretary, Deputy Chair, Chair]',
        ],

        'start_date' =>         [
            'label' => 'Start Date',
            'rules' => 'required',
        ],

        'end_date' =>         [
            'label' => 'End Date',
            'rules' => 'required',
        ],
    ];
}
