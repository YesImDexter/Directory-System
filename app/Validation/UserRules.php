<?php
namespace App\Validation;
use App\Models\UserModel;

//When creating custom rule, make sure to add it into the Config/Validation.php file

class UserRules
{

  public function validateUser(string $str, string $fields, array $data){
    $model = new UserModel();
    $user = $model->where('email', $data['email'])->first();

    if($user){
        return password_verify($data['password'], $user['password']);
    } else {
        return false;
    }
  }
}
