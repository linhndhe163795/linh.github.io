<?php

require_once 'models/admin.php';
require_once 'controllers/base_controller.php';
require_once 'helper/common.php';
require_once 'helper/validation.php';
session_start();

class CreateController extends BaseController {

    function __construct() {
        $this->folder = 'pages';
    }

    function create() {
        $this->render("create");
    }

    public function createAdmin() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == 1) {
            if (isset($_POST['submit'])) {
                $avatar = $_FILES['avatar']['name'];
                $_POST['avatar'] = $avatar;
                // step 1 @validate
                $validate = Validation::validateCreateAdmin($_POST);
                // step 2 @ok => save / @fail => show errors
                if ($validate['status']) {
                    Admin::createNewAccount($_POST);
                    $this->render("search", [
                        'messages' => 'Create new account successfully'
                    ]);
                } else {
                    $this->render("create", [
                        'errors' => $validate['messages'],
                        'valid' => $validate['valid']
                    ]);
                }
            } else {
                $this->render("create");
            }
        } else {
            $this->render("error");
            header("Refresh: 3; index.php?controller=login&action=userlogin");
        }
    }

}

?>