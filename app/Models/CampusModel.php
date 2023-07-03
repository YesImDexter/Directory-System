<?php

namespace App\Models;

use CodeIgniter\Model;

class CampusModel extends Model
{
    protected $table = 'campus';
    protected $primaryKey = "camp_id";
    protected $allowedFields = [
        'camp_id',
        'camp_name',
        'camp_acronym',
        'camp_desc',
        'camp_address',
        'camp_office_no',
        'camp_image',
        'camp_map_url',
        'camp_website',
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
}
