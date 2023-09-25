<?php

require_once 'base_controller.php';
require_once 'models/admin.php';
require_once 'models/user.php';
require_once 'helper/common.php';
require_once 'helper/validation.php';
require_once 'helper/const.php';

session_start();

class EditController extends BaseController {

    function __construct() {
        $this->folder = 'pages';
    }

    public function edit() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN) {
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
            $avatar = $_FILES['avatar']['name']; // Lấy tên tệp ảnh
            $previousAvatar = isset($_SESSION['previousAvatar']) ? $_SESSION['previousAvatar'] : $detailUser[0]['avatar'];
            if (isset($_POST['submitEdit'])) {
                if (!empty($avatar)) {
                    $_POST['avatar'] = $avatar;
                    $_SESSION['previousAvatar'] = $avatar;
                } else {
                    $_POST['avatar'] = $previousAvatar;
                }
                $validate = Validation::validateInput($_POST);
                $validateImage = Validation::validateImageForEdit($_POST);
                if ($validate['status'] && $validateImage['status']) {
                    Admin::editAdmin($_POST);
                    unset($_SESSION['previousAvatar']);
                    $this->render("search", [
                        'messages' => 'Edit account successfully'
                    ]);
                } else {
                    $this->render("edit", [
                        'errors' => $validate['messages'],
                        'valid' => isset($validate['valid']) ? $validate['valid'] : "",
                        'errorsImage' => $validateImage['messages'],
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
                if ($del_flag == DEL_FLAG_ACTIVE) {
                    $update = UPDATE;
                    Admin::deleteAdmin($id, $update);
                    echo 'Delete Successfully';
                    header("Refresh: 3; index.php?controller=search&action=searchAdmin");
                }
            } else {
                $this->render("search");
            }
        } else {
            $this->render("error");
            header("Refresh: 3; index.php?controller=login&action=userlogin");
        }
    }

    public function loadDataEdit() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN ||
                isset($_SESSION['role_type']) == ADMIN) {
            $detailUser = User::detailUser($_GET['id']);
            if (isset($_GET['id'])) {
                $checkId = User::checkIdUser($_GET['id']);
                if (!$checkId) {
                    echo 'ID không hợp lệ';
                    header("Refresh: 3; index.php?controller=search&action=searchUser");
                    exit();
                } else {
                    $this->render("edituser", array('detail' => $detailUser));
                }
            }
        } else {
            $this->render("error");
        }
    }

    public function editUser() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN ||
                ($_SESSION['role_type']) == ADMIN) {
            $detailUser = User::detailUser($_GET['id']);
            if (isset($_POST['submitEdit'])) {
                $avatar = $_FILES['avatar']['name']; // Lấy tên tệp ảnh
                $previousAvatar = isset($_SESSION['previousAvatar']) ? $_SESSION['previousAvatar'] : $detailUser[0]['avatar'];
                if (!empty($avatar)) {
                    $_POST['avatar'] = $avatar;
                    $_SESSION['previousAvatar'] = $avatar;
                } else {
                    $_POST['avatar'] = $previousAvatar;
                }

                $validate = Validation::validateInput($_POST);
                $validateImage = Validation::validateImageForEdit($_POST);
                if ($validate['status'] && $validateImage['status']) {
                    User::editUser($_POST);
                    unset($_SESSION['previousAvatar']);
                    $this->render("searchuser", [
                        'messages' => 'Edit account successfully'
                    ]);
                } else {
                    $this->render("edituser", [
                        'errors' => $validate['messages'],
                        'valid' => isset($validate['valid']) ? $validate['valid'] : "",
                        'errorsImage' => $validateImage['messages'],
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
                ($_SESSION['role_type']) == ADMIN) {
            if (isset($_POST['delete_account'])) {
                $id = $_POST['delete_account'];
                $del_flag = $_POST['del_flag'];
                if ($del_flag == DEL_FLAG_ACTIVE) {
                    $update = UPDATE;
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