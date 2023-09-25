<?php

require_once 'models/admin.php';
require_once 'controllers/base_controller.php';
require_once 'helper/common.php';
require_once 'helper/validation.php';
require_once 'helper/const.php';

session_start();



class CreateController extends BaseController {

    function __construct() {
        $this->folder = 'pages';
    }

    function create() {
        $this->render("create");
    }

    public function createAdmin() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN) {
            if (isset($_POST['submit'])) {
                $avatar = $_FILES['avatar']['name'];
                $previousAvatar = isset($_SESSION['previousAvatar']) ? $_SESSION['previousAvatar'] : $avatar;

                if (!empty($avatar)) {
                    $_POST['avatar'] = $avatar;
                    $_SESSION['previousAvatar'] = $avatar;
                } else {
                    $_POST['avatar'] = $previousAvatar;
                }
                // step 1 @validate
                $validate = Validation::validateInput($_POST);
                $validateImage = Validation::validateImageForCreate($_POST);
                // step 2 @ok => save / @fail => show errors
                if ($validate['status']&& $validateImage['status']) {

                    Admin::createNewAccount($_POST);
                    unset($_SESSION['previousAvatar']);
                    $this->render("search", [
                        'messages' => 'Create new account successfully'
                    ]);
                } else {
                    $this->render("create", [
                        'errors' => $validate['messages'],
                        'errorsImage' => $validateImage['messages'],
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