<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator as v;

class AuthController extends BaseController {
  public function getLogin() {
    return $this->renderHTML('login.twig');
  }

  public function postSaveUser($request){

        $postData = $request->getParsedBody();

        $user = new User();
        $user->email = $postData['email'];
        $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
        $user->save();

    return $this->renderHTML('addUser.twig');
  }
}