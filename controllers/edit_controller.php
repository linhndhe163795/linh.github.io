<?php

require_once 'base_controller.php';
require_once 'models/admin.php';
require_once 'models/user.php';
require_once 'helper/common.php';
require_once 'helper/validation.php';

session_start();
define('SUPER_ADMIN', 1);
define('ADMIN', 2);

class EditController extends BaseController {

    function __construct() {
        $this->folder = 'pages';
    }

    public function edit() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) ==SUPER_ADMIN) {
            $detailAdmin = Admin::detailAdmin($_GET['id']);
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $checkId = Admin::checkIdAdmin($id);
                if (!$checkId) {
                    echo 'ID không hợp lệ';
                    header("Refresh: 3; index.php?controller=search&action=searchAdmin");
                    exit();
                } else {
                    $this->render("edit", array('detail' => $detailAdmin));
                }
            }
        } else {
            $this->render("error");
        }
    }

    public function editAdmin() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN) {
            $detailUser = Admin::detailAdmin($_GET['id']);
            if (isset($_POST['submitEdit'])) {
                $avatar = $_FILES['avatar']['name'];
                $_POST['avatar'] = $avatar;
//                dd($_POST);
                $validate = Validation::validateInput($_POST);
                if ($validate['status']) {
                    Admin::editAdmin($_POST);
                    $this->render("search", [
                        'messages' => 'Edit account successfully'
                    ]);
                } else {
                    $this->render("edit", [
                        'errors' => $validate['messages'],
                        'valid' => $validate['valid'],
                        'detail' => $detailUser
                    ]);
                }
            } else {
                $this->render("edit");
            }
        } else {
            $this->render("error");
        }
    }

    public function delete() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN) {
            if (isset($_POST['delete_account'])) {
                $id = $_POST['delete_account'];
                $del_flag = $_POST['del_flag'];
                if ($del_flag === '0') {
                    $update = 1;
                    Admin::deleteAdmin($id, $update);
                    echo 'Delete Successfully';
                    header("Refresh: 3; index.php?controller=search&action=searchAdmin");
                }
            } else {
                $this->render("search");
            }
        } else {
            $this->render("error");
        }
    }

    public function loadDataEdit() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN ||
                isset($_SESSION['role_type']) == ADMIN) {
            $detailUser = User::detailUser($_GET['id']);
            $this->render("edituser", array('detail' => $detailUser));
        } else {
            $this->render("error");
        }
    }

    public function editUser() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN ||
                ($_SESSION['role_type']) == 2) {
            $detailUser = User::detailUser($_GET['id']);
            if (isset($_POST['submitEdit'])) {
                $avatar = $_FILES['avatar']['name'];
                $_POST['avatar'] = $avatar;
                $validate = Validation::validateInput($_POST);
                if ($validate['status']) {
                    User::editUser($_POST);
                    $this->render("searchuser", [
                        'messages' => 'Edit account successfully'
                    ]);
                } else {
                    $this->render("edituser", [
                        'errors' => $validate['messages'],
                        'valid' => $validate['valid'],
                        'detail' => $detailUser
                    ]);
                }
            } else {
                $this->render("error");
                header("Refresh: 3; index.php?controller=login&action=userlogin");
            }
        }
    }

    public function deleteUser() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN ||
                ($_SESSION['role_type']) === ADMIN) {
            if (isset($_POST['delete_account'])) {
                $id = $_POST['delete_account'];
                $del_flag = $_POST['del_flag'];
                if ($del_flag === '0') {
                    $update = 1;
                    User::deleteUser($id, $update);
                    echo 'Delete Successfully';
                    header("Refresh: 3; index.php?controller=search&action=searchUser");
                }
            } else {
                $this->render("search");
            }
        } else {
            $this->render("error");
            header("Refresh: 3; index.php?controller=login&action=userlogin");
        }
    }

}

?>