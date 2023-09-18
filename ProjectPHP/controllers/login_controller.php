<?php

require_once 'controllers/base_controller.php';
require_once 'models/admin.php';
require_once 'models/user.php';
require_once 'helper/common.php';
session_start();

class LoginController extends BaseController {

    function __construct() {
        $this->folder = "pages";
    }

    public function dangnhap() {
        if (isset($_POST['submit'])) {
            $em = $_POST['email'];
            $ps = $_POST['password'];
            $ps = md5($_POST['password']);
            $check = Admin::checkAccount($em, $ps);
            $infor = Admin::getInfor($em, $ps);

            if (empty($em) && empty($ps)) {
                $this->render("login", ['messErrorEamil' => 'Email can not be blank',
                    'messErrorPassword' => 'Password can not be blank',
                    ]);
            } else if (empty($em)) {
                $this->render("login", ['messErrorEamil' => 'Email can not be blank',
                    'password' => $ps]);
            } else if (empty($ps)) {
                $this->render("login", ['messErrorPassword' => 'Password can not be blank',
                    'email' => $em]);
            } else if ($check === TRUE) {
                $_SESSION['username'] = $em;
                $_SESSION['password'] = $ps;
                $_SESSION['role_type'] = $infor['role_type'];
                $this->render("homepage");
            } else {
                $list = 'sai mat khau';
                $this->render("login", array('list' => $list , 'email'=>$em));
            }
        } else {
            $this->render("login");
        }
    }

    public function userlogin() {
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = md5($password);
            $check = User::checkAccount($email, $password);
            $infor = User::getInfor($email, $password);
            if ($check === TRUE) {
                $_SESSION['username'] = $email;
                $_SESSION['password'] = $password;
//                dd($infor);
                $this->render("profile", ["infor" => $infor]);
            } else {
                $list = 'sai mat khau';
                $this->render("loginuser", array('list' => $list));
            }
        } else {
            $this->render("loginuser");
        }
    }

    public function error() {
        $this->render('error');
    }

}
