<?php

require_once 'models/admin.php';
require_once 'controllers/base_controller.php';
require_once 'helper/common.php';
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
                $avatar1 = Admin::checkUploadFile();
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $avatar = $avatar1;
                $passwordVerify = $_POST['verifyPassword'];
                $passwordVerify = $_POST['verifyPassword'];
                if (isset($_POST['role_type'])) {
                    $role_type = $_POST['role_type'];
                } else {
                    $role_type = '';
                }
                if (empty($name)) {
                    $this->render("create", [
                        'messUpload' => "Choose Image",
                        'email' => $email,
                        'messName' => "Name can not be blank",
                        'messRadio' => 'Choose Type Again'
                    ]);
                } else if (empty($email) && $avatar1 !== null) {
                    $this->render("create", [
                        'messUpload' => "Choose Image Again",
                        'name' => $name,
                        'messEmail' => "Email can not be blank",
                        'messRadio' => 'Choose Type Again']);
                } else if (empty($password) && $avatar1 !== null) {
                    $this->render("create", [
                        'messUpload' => "Choose Image Again",
                        'name' => $name,
                        'email' => $email,
                        'messPassword' => "Password can not be blank",
                        'messRadio' => 'Choose Type Again']);
                } else if (empty($passwordVerify) && $avatar1 !== null) {
                    $this->render("create", [
                        'messUpload' => "Choose Image Again",
                        'name' => $name,
                        'email' => $email,
                        'messVeriPass' => "Password Verify can not be blank",
                        'messRadio' => 'Choose Type Again']);
                } else if ($avatar1 === null) {
                    $this->render("create", [
                        'messUpload' => "Choose Image",
                        'name' => $name,
                        'email' => $email,
                        'messRadio' => 'Choose Type Again']);
                } else if (empty($role_type)) {
                    $this->render("create", [
                        'messRadio' => "Choose Role Type",
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'messUpload' => "Choose Again Image"]);
                } else if (Admin::checkDuplicateEmail($email, 0)) {
                    $this->render("create", [
                        'messEmail' => "Email is exist",
                        'account' => $account,
                        'messUpload' => "Choose Again Image",
                        'messRadio' => 'Choose Type Again']);
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $this->render("create", [
                        'messUpload' => 'Choose Image',
                        'name' => $name,
                        'messEmail' => 'Email is invalid'
                    ]);
                } else if ($password !== $passwordVerify) {
                    $account = [
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'avatar' => $avatar1,
                    ];
                    $this->render("create", [
                        'messPassword' => 'Password not match',
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'messUpload' => "Choose Again Image",
                        'messRadio' => 'Choose Type Again']);
                } else {
                    $account = [
                        'name' => $_POST['name'],
                        'email' => $_POST['email'],
                        'password' => $_POST['password'],
                        'avatar' => $avatar1,
                        'role_type' => $_POST['role_type'],
                        'del_flag' => 0
                    ];
                    Admin::createNewAccount($account);
                    $this->render("homepage", ['messOfCreate' => 'Create successfully']);
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