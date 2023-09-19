<?php

require_once 'controllers/base_controller.php';
require_once 'models/admin.php';
require_once 'models/user.php';
require_once 'helper/common.php';
require_once 'helper/validation.php';
session_start();

class LoginController extends BaseController {

    function __construct() {
        $this->folder = "pages";
    }

    public function dangnhap() {
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $validate = Validation::validateLogin($_POST);
            $check = Admin::checkAccount($email, $password);
            if ($validate['status']) {
                if ($check) {
                    $infor = Admin::getInfor($email, $password);
                    $_SESSION['username'] = $email;
                    $_SESSION['password'] = $password;
                    $_SESSION['role_type'] = $infor['role_type'];
                    $this->render("homepage");
                } else {
                    $this->render("login", [
                        'messages' => 'Incorrect Password Or Email'
                    ]);
                }
            } else {
                $this->render("login", [
                    'errors' => $validate['messages'],
                    'valid' => $validate['valid']
                ]);
            }
        } else {
            $this->render("login");
        }
    }

    public function userlogin() {
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $validate = Validation::validateLogin($_POST);
            $check = User::checkAccount($email, $password);
            if ($validate['status']) {
                if ($check) {
                    $infor = User::getInfor($email, $password);
                    $_SESSION['username'] = $email;
                    $this->render("profile", ["infor" => $infor]);
                } else {
                    $this->render("loginuser", [
                        'messages' => 'Incorrect username or password!'
                    ]);
                }
            } else {
                $this->render("loginuser", [
                    'errors' => $validate['messages'],
                    'valid' => $validate['valid']
                ]);
            }
        } else {
            $this->render("loginuser");
        }
    }

    public function error() {
        $this->render('error');
    }

}
