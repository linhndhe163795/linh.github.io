<?php

require_once 'controllers/base_controller.php';
require_once 'helper/common.php';
require_once 'models/admin.php';
require_once 'models/user.php';
require_once 'helper/const.php';
session_start();


class SearchController extends BaseController {

    function __construct() {
        $this->folder = 'pages';
    }

    public function searchAdmin() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN) {
            $email = '';
            $name = '';
            $email = isset($_GET['email']) ? $_GET['email'] : '';
            $name = isset($_GET['name']) ? $_GET['name'] : '';

            isset($_GET['page']) ? $page = $_GET['page'] : $page = DEFAULT_PAGE;
            $end = PAGING;
            $start = ($page - 1) * $end;

            $number_of_result = Admin::countAdmin($email, $name);
            $number_of_page = ceil($number_of_result / $end);
            $list = Admin::searchbyNameandEmail($email, $name, $start, $end);

            $this->render("search", [
                'list' => $list,
                'page' => $page,
                'name' => $name,
                'email' => $email,
                'number_of_page' => $number_of_page,
            ]);
        } else {
            $this->render("error");
            header("Refresh: 3; index.php?controller=login&action=userlogin");
        }
    }

    public function searchUser() {
        if (isset($_SESSION['role_type']) && ($_SESSION['role_type']) == SUPER_ADMIN ||
                ($_SESSION['role_type']) == ADMIN) {
            $email = '';
            $name = '';
            $email = isset($_GET['email']) ? $_GET['email'] : '';
            $name = isset($_GET['name']) ? $_GET['name'] : '';

            isset($_GET['page']) ? $page = $_GET['page'] : $page = DEFAULT_PAGE;
            $end = PAGING;
            $start = ($page - 1) * $end;

            $number_of_result = User::countUser($email, $name);
            $number_of_page = ceil($number_of_result / $end);
            $list = User::searchUserByNameAndEmail($name, $email, $start, $end);
            $this->render("searchuser", [
                'list' => $list,
                'page' => $page,
                'name' => $name,
                'email' => $email,
                'number_of_page' => $number_of_page,
            ]);
        } else {
            $this->render("error");
            header("Refresh: 3; index.php?controller=login&action=userlogin");
        }
    }

}
