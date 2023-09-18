<?php

require_once 'models/admin.php';
require_once 'controllers/base_controller.php';
require_once 'controllers/login_controller.php';
//session_start();
class HomeController extends BaseController {

    function __construct() {
        $this->folder = "pages";
    }

    public function homepage() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->render("homepage");
    }

    public function logout() {
        isset($_SESSION) ? session_destroy() : " ";
        $this->render("login");
    }
     public function logoutuser() {
        isset($_SESSION) ? session_destroy() : " ";
        $this->render("loginuser");
    }
    public function error() {
        $this->render('error');
    }
    

}
