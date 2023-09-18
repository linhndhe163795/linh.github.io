<?php

require_once 'base_controller.php';
require_once 'models/admin.php';
require_once 'models/user.php';
require_once 'helper/common.php';
session_start();

class EditController extends BaseController {

    function __construct() {
        $this->folder = 'pages';
    }

    public function edit() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == 1) {
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
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == 1) {
            $detailUser = Admin::detailAdmin($_GET['id']);

            if (isset($_POST['submitEdit'])) {
                $verify = $_POST['verifyPassword'];
                $detailUser = Admin::detailAdmin($_GET['id']);
                $avatar1 = Admin::checkUploadFile();
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $verifyPassword = $_POST['verifyPassword'];
                $active = $_POST['active'];
                $id = $_GET['id'];
//                var_dump($checkAccount);
                if ($avatar1 === null) {
                    $this->render("edit", ['messUpload' => 'Choose Image',
                        'detail' => $detailUser,
                        'name' => $name,
                        'email' => $email,
                        'active' => $active,
                        'detail' => $detailUser
                    ]);
                } else if (empty($name) || $avatar1 === null) {
                    $this->render("edit", [
                        'messUpload' => 'Choose Image Again',
                        'detail' => $detailUser,
                        'email' => $email,
                        'active' => $active,
                        'messName' => 'Name can not be blank',
                        'detail' => $detailUser
                    ]);
                } else if (empty($email) || $avatar1 === null) {
                    $this->render("edit", [
                        'messUpload' => 'Choose Image Again',
                        'detail' => $detailUser,
                        'name' => $name,
                        'active' => $active,
                        'detail' => $detailUser,
                        'messEmail' => 'Email can not be blank'
                    ]);
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $avatar1 === null) {
                    $this->render("edit", [
                        'messUpload' => 'Choose Image Again',
                        'detail' => $detailUser,
                        'name' => $name,
                        'active' => $active,
                        'detail' => $detailUser,
                        'messEmail' => 'Email is invalid'
                    ]);
                } else if (empty($password) || $avatar1 === null) {
                    $this->render("edit", [
                        'messUpload' => 'Choose Image Again',
                        'detail' => $detailUser,
                        'name' => $name,
                        'email' => $email,
                        'detail' => $detailUser,
                        'messPassword' => 'Password can not be blank'
                    ]);
                } else if (empty($verifyPassword) || $avatar1 === null) {
                    $this->render("edit", [
                        'messUpload' => 'Choose Image Again',
                        'detail' => $detailUser,
                        'name' => $name,
                        'email' => $email,
                        'detail' => $detailUser,
                        'messVeriPassword' => 'Verify Password can not be blank'
                    ]);
                } else if (Admin::checkDuplicateEmail($email, $id) || $avatar1 === null) {
//                    dd($checkAccount);
                    $this->render("edit", [
                        'messUpload' => 'Choose Image Again',
                        'detail' => $detailUser,
                        'name' => $name,
                        'detail' => $detailUser,
                        'messEmail' => 'Email is exist'
                    ]);
                } else if ($verifyPassword !== $password || $avatar1 === null) {
                    $this->render("edit", [
                        'messPassword' => "Password not match",
                        'messUpload' => 'Choose Image Again',
                        'detail' => $detailUser,
                        'name' => $name,
                        'email' => $email,
                        'detail' => $detailUser
                    ]);
                } else {
                    $admin = [$name,
                        $email,
                        $password,
                        $avatar1,
                        $active,
                        $id];
                    Admin::editAdmin($admin);
                    $this->render("search", ['mess' => "Edit Successfully"]);
                }
            } else {
                $this->render("edit");
            }
        } else {
            $this->render("error");
        }
    }

    public function delete() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == 1) {
            if (isset($_POST['deleteaccount'])) {
                $id = $_POST['deleteaccount'];
                $del_flag = $_POST['del_flag'];
                if ($del_flag === '0') {
                    $update = 1;
                    Admin::deleteAdmin($id, $update);
                    echo '<div style="color: red">Delete Successfully</div>';
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
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == 1 ||
                isset($_SESSION['role_type']) == 2) {
            $detailUser = User::detailUser($_GET['id']);
            $this->render("edituser", array('detail' => $detailUser));
        } else {
            $this->render("error");
        }
    }

    public function editUser() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == 1 ||
                ($_SESSION['role_type']) == 2) {
            if (isset($_POST['submitEdit'])) {
                $detailUser = User::detailUser($_GET['id']);
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $status = $_POST['status'];
                $id = $_GET['id'];
                $verifyPassword = $_POST['verifyPassword'];
//                dd($email);
                $avatar1 = Admin::checkUploadFile();
                if ($avatar1 === null) {
                    $this->render("edituser", ['messUpload' => "Choose Image",
                        'name' => $name,
                        'email' => $email,
                        'detail' => $detailUser,
                    ]);
                } else if (empty($name)) {
//                    echo "name empty";
                    $this->render("edituser", ['messName' => "Name can not be blank",
                        'messUpload' => "Choose Image Again",
                        'email' => $email,
                        'detail' => $detailUser,
                    ]);
                } else if (empty($email)) {
//                    echo "123 email empty",
                    $this->render("edituser", ['messEmail' => "Email can not be blank",
                        'messUpload' => "Choose Image Again",
                        'name' => $name,
                        'detail' => $detailUser,
                    ]);
                } else if (empty($password)) {
                    $this->render("edituser", ['messPassword' => "Password can not be blank",
                        'messUpload' => "Choose Image Again",
                        'email' => $email,
                        'name' => $name,
                        'detail' => $detailUser,
                    ]);
                } else if (empty($verifyPassword)) {
                    $this->render("edituser", [
                        'messVerifyPassword' => "Verify Password can not be blank",
                        'messUpload' => "Choose Image Again",
                        'email' => $email,
                        'name' => $name,
                        'detail' => $detailUser,
                    ]);
                } else if (User::checkDuplicateEmail($email, $id)) {
                    $this->render("edituser", ['messEmail' => "Email is exist",
                        'messUpload' => "Choose Image Again",
                        'name' => $name,
                        'detail' => $detailUser,
                    ]);
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->render("edituser", ['messEmail' => "Email is invalid",
                        'messUpload' => "Choose Image Again",
                        'name' => $name,
                        'detail' => $detailUser,
                    ]);
                } else if ($password !== $verifyPassword) {
                    $this->render("edituser", ['messPassword' => "Password not match",
                        'messUpload' => "Choose Image Again",
                        'name' => $name,
                        'email' => $email,
                        'detail' => $detailUser,
                        'detail' => $detailUser,
                    ]);
                } else {
                    $user = [
                        $avatar1,
                        $name,
                        $email,
                        $password,
                        $status,
                        $id
                    ];
                    User::editUser($user);
                    $this->render("searchuser", ['messEdit' => "Edit Successfully"]);
                }
            } else {
                $this->render("searchuser");
            }
        } else {
            $this->render("error");
            header("Refresh: 3; index.php?controller=login&action=userlogin");
        }
    }

    public function deleteUser() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == 1 ||
                ($_SESSION['role_type']) === 2) {
            if (isset($_POST['deleteaccount'])) {
                $id = $_POST['deleteaccount'];
                $del_flag = $_POST['del_flag'];
                if ($del_flag === '0') {
                    $update = 1;
                    User::deleteUser($id, $update);
                    echo '<div style="color: red">Delete Successfully</div>';
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