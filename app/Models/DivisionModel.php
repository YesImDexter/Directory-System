<?php

namespace App\Models;
use CodeIgniter\Model;
class DivisionModel extends Model
{
    protected $table = 'division';
    protected $primaryKey = "div_id";
    protected $allowedFields = [
        'camp_id',
        'div_name',
        'div_image',
        'div_desc'
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

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
        'camp_id' =>         [
            'label' => 'Campus',
            'rules' => 'required',
        ],

        'div_name' =>         [
            'label' => 'Division Name',
            'rules' => 'required',
        ],

        'validate_image' =>        [
            'label' => 'Image Uploaded',
            'rules' => "ext_in[img,jpg,png,jpeg]|max_size[img, 2e+6]",
            'errors' => [
                'max_size' => 'Maximum Image Uploaded is 3 MB'
            ],
        ],

        // 'div_desc' =>         [
        //     'label' => 'Division Description',
        //     'rules' => '',
        // ],
    ];
}
