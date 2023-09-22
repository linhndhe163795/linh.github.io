
<?php

require_once('connection.php');
//require_once('./helper/common.php');


if (isset($_GET['controller'])) {
  $controller = $_GET['controller'];
  if (isset($_GET['action'])) {
    $action = $_GET['action'];
  } else {
    $action = 'index';
  }
} else {
  $controller = 'login';
  $action = 'dangnhap';
}
require_once('routes.php');
