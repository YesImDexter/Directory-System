<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table = 'staff';
    protected $primaryKey = "staff_uid";
    protected $allowedFields = [
        'staff_id',
        'div_id',
        'staff_title',
        'staff_name',
        'staff_position',
        'staff_unit',
        'staff_type',
        'staff_image',
        'staff_desc',
        'staff_email',
        'staff_tel',
        'staff_office',
        'staff_fax',
        'deleted_at',
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

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
        'staff_name' =>         [
            'label' => 'Staff Name',
            'rules' => 'required',
        ],

        'staff_id' =>         [
            'label' => 'Staff ID',
            'rules' => 'required|min_length[5]|max_length[6]|is_unique[staff.staff_id,staff_uid,{uid}]',
            'errors' => [
                'is_unique' => 'That ID Has Already Been Registered',
                'min_length' => 'Staff ID Too Short, Must Be 5 - 6 In Length',
                'max_length' => 'Staff ID Too Long, Must Be 5 - 6 In Length',
            ],
        ],

        // 's_camp' => '',
        // 's_div' => '',

        'staff_title' =>        [
            'label' => 'Staff Title',
            'rules' => "in_list[Unassigned, Dato, Datuk, Dato, Dato' Seri, Dato Sri, Datu, Dr, Professor]"
        ],

        'staff_position' =>        [
            'label' => 'Staff Position',
            'rules' => "in_list[Unassigned, Deputy Executive, Director, Senior Manager, Manager, Senior Executive, Executive, Assistant, Techician]"
        ],

        'staff_unit' =>        [
            'label' => 'Staff Unit',
            'rules' => "in_list[Unassigned, Information Technology, Facility, Human Resources, Marketing, Exam Unit, Safety And Health]"
        ],

        'staff_type' =>        [
            'label' => 'Staff Type',
            'rules' => "in_list[Unassigned, Teaching, Non-Teaching]"
        ],

        // 'staff_image' => '',
        // 'staff_desc' => ''

        'validate_image' =>        [
            'label' => 'Image Uploaded',
            'rules' => "ext_in[img,jpg,png,jpeg]|max_size[img, 3e+6]",
            'errors' => [
                'max_size' => 'Maximum Image Uploaded is 3 MB'
            ],
        ],

        'staff_email' =>        [
            'label' => 'Staff Email',
            'rules' => "is_unique[staff.staff_email,staff_uid,{uid}]|valid_email",
            'errors' => [
                'is_unique' => 'That Email Has Already Been Taken'
            ],
        ],
        // 'staff_tel' => '',
        'staff_office' => [
            'label' => 'Office Number Extension',
            'rules' => "max_length[3]|min_length[3]"
        ],
        // 'staff_fax' => '',
    ];
}
