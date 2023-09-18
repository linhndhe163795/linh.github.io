<?php

include_once './helper/common.php';

class User {

    public $id;
    public $name;
    public $facebook;
    public $password;
    public $email;
    public $avatar;
    public $status;
    public $ins_id;
    public $upd_id;
    public $ins_datetime;
    public $upd_datetime;
    public $del_flag;

    function __construct($id, $name, $facebook, $password, $email, $avatar, $status, $ins_id, $upd_id, $ins_datetime, $upd_datetime, $del_flag) {
        $this->id = $id;
        $this->name = $name;
        $this->facebook = $facebook;
        $this->password = $password;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->status = $status;
        $this->ins_id = $ins_id;
        $this->upd_id = $upd_id;
        $this->ins_datetime = $ins_datetime;
        $this->upd_datetime = $upd_datetime;
        $this->del_flag = $del_flag;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getFacebook() {
        return $this->facebook;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getAvatar() {
        return $this->avatar;
    }

    function getStatus() {
        return $this->status;
    }

    function getIns_id() {
        return $this->ins_id;
    }

    function getUpd_id() {
        return $this->upd_id;
    }

    function getIns_datetime() {
        return $this->ins_datetime;
    }

    function getUpd_datetime() {
        return $this->upd_datetime;
    }

    function getDel_flag() {
        return $this->del_flag;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setIns_id($ins_id) {
        $this->ins_id = $ins_id;
    }

    function setUpd_id($upd_id) {
        $this->upd_id = $upd_id;
    }

    function setIns_datetime($ins_datetime) {
        $this->ins_datetime = $ins_datetime;
    }

    function setUpd_datetime($upd_datetime) {
        $this->upd_datetime = $upd_datetime;
    }

    function setDel_flag($del_flag) {
        $this->del_flag = $del_flag;
    }

    public static function searchUserByNameAndEmail($name, $email, $start, $end) {
        $db = DB::getInstance();
        $list = [];
        $stmt = $db->prepare('SELECT id , avatar, name, email, status,del_flag  '
                . 'FROM users WHERE email LIKE :email AND name LIKE :name and '
                . 'del_flag = 0 LIMIT  :start, :end');
        $email = '%' . $email . '%';
        $name = '%' . $name . '%';
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':end', $end, PDO::PARAM_INT);
        $stmt->execute();
//        $list = $stmt->fetchAll();
        foreach ($stmt->fetchAll() as $item) {
            $list [] = [
                'id' => $item['id'],
                'avatar' => $item['avatar'],
                'name' => $item['name'],
                'email' => $item['email'],
                'status' => $item['status'],
                'del_flag' => $item['del_flag']
            ];
        }
        return $list;
    }

    public static function editUser($user = array()) {
        $db = DB::getInstance();
        $password = md5($user[3]);
        $stmt = $db->prepare('UPDATE users SET avatar = :avatar , name = :name,'
                . 'email = :email, password = :password, status = :status where id = :id');
        $stmt->bindParam(':avatar', $user[0], PDO::PARAM_STR);
        $stmt->bindParam(':name', $user[1], PDO::PARAM_STR);
        $stmt->bindParam(':email', $user[2], PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':status', $user[4], PDO::PARAM_INT);
        $stmt->bindParam(':id', $user[5], PDO::PARAM_INT);
//        dd($user);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function detailUser($id) {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT id,avatar,name,email,password,status from users where id = :id ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        dd($list);
        if (!empty($list)) {
//            dd($list);
            return $list;
        } else {
            return []; // Trả về mảng rỗng nếu không tìm thấy dữ liệu
        }
    }

    public static function checkDuplicateEmail($email, $id) {
    $db = DB::getInstance();
    $stmt = $db->prepare('SELECT email '
            . 'FROM users '
            . 'WHERE email = :email'
            . ' AND id != :id'); 

    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
//        dd($result);
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteUser($id, $del_flag) {
        $db = DB::getInstance();
        $stmt = $db->prepare('UPDATE users SET del_flag = :del_flag where id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
//        dd($stmt).'<br>';
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function getInfor($email, $password) {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT * FROM users where email = :email '
                . 'AND password = :password and del_flag=0');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($list)) {
//            dd($list);
            return $list;
        } else {
            return []; // Trả về mảng rỗng nếu không tìm thấy dữ liệu
        }
    }

    public static function checkAccount($email, $password) {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT email, password FROM users WHERE '
                . 'email = :email AND password = :password and del_flag = 0');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchAll();
//        dd($result);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function countUser($email, $name) {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT COUNT(ID) FROM users where email like :email and name like :name and del_flag = 0');
        $email = '%' . $email . '%';
        $name = '%' . $name . '%';
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
//        dd($count);
        return $count;
    }

}

?>
