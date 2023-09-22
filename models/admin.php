<?php

require_once 'helper/const.php';

class Admin {

    public $id;
    public $name;
    public $password;
    public $email;
    public $avatar;
    public $role_type;
    public $ins_id;
    public $upd_id;
    public $ins_datetime;
    public $upd_datetime;
    public $del_flag;

    function __construct($id, $name, $password, $email, $avatar, $role_type, $ins_id, $upd_id, $ins_datetime, $upd_datetime, $del_flag) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->role_type = $role_type;
        $this->ins_id = $ins_id;
        $this->upd_id = $upd_id;
        $this->ins_datetime = $ins_datetime;
        $this->upd_datetime = $upd_datetime;
        $this->del_flag = $del_flag;
    }

    static function checkAccount($email, $password) {
        $db = DB::getInstance();
        $del_flag = DEL_FLAG_ACTIVE;

        $stmt = $db->prepare('SELECT email, password FROM admin WHERE '
                . 'email = :email AND password = :password and del_flag = :del_flag');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result ? true : false;
    }

    static function searchbyNameandEmail($email, $name, $start, $end) {
        $db = DB::getInstance();
        $list = [];
        $del_flag = DEL_FLAG_ACTIVE;

        $stmt = $db->prepare('SELECT id, name, email, password, role_type, avatar,'
                . 'del_flag FROM admin WHERE email LIKE :email AND name LIKE '
                . ':name and del_flag = :del_flag  LIMIT  :start, :end');
        $email = '%' . $email . '%';
        $name = '%' . $name . '%';

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':end', $end, PDO::PARAM_INT);
        $stmt->bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $item) {
            $list [] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => $item['password'],
                'role_type' => $item['role_type'],
                'avatar' => $item['avatar'],
                'del_flag' => $item['del_flag']
            ];
        }
        return $list;
    }

    static function countAdmin($email, $name) {
        $db = DB::getInstance();
        $del_flag = DEL_FLAG_ACTIVE;

        $stmt = $db->prepare('SELECT COUNT(ID) FROM admin where email like :email '
                . 'and name like :name and del_flag = :del_flag');
        $email = '%' . $email . '%';
        $name = '%' . $name . '%';

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count;
    }

    public static function detailAdmin($id) {
        $db = DB::getInstance();

        $stmt = $db->prepare('SELECT id,name,email,password,avatar,'
                . 'role_type from admin where id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($list)) {
            return $list;
        } else {
            return [];
        }
    }

    public static function editAdmin($admin = array()) {
        $db = DB::getInstance();
        $pass = md5($admin['password']);
        $stmt = $db->prepare('UPDATE admin SET name = :name, email = :email, '
                . 'password = :password, avatar = :avatar, role_type = :role_type WHERE id = :id');

        $stmt->bindParam(':name', $admin['name'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $admin['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $admin['avatar'], PDO::PARAM_STR);
        $stmt->bindParam(':role_type', $admin['role_type'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $admin['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function createNewAccount($account) {
        $db = DB::getInstance();
        $passwordmd5 = md5($account['password']);
        $account['del_flag'] = DEL_FLAG_ACTIVE;

        $stmt = $db->prepare('INSERT INTO admin (name, email, password, avatar, role_type, del_flag)'
                . 'VALUES (:name, :email, :password, :avatar, :role_type, :del_flag)');
        $stmt->bindParam(':name', $account['name'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $account['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordmd5, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $account['avatar'], PDO::PARAM_STR);
        $stmt->bindParam(':role_type', $account['role_type'], PDO::PARAM_INT);
        $stmt->bindParam(':del_flag', $account['del_flag'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkDuplicateEmail($email, $id) {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT * '
                . 'FROM admin '
                . 'WHERE email = :email and del_flag = :del_flag and id != :id');
        $del_flag = DEL_FLAG_ACTIVE;

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result > 0;
    }

    public static function deleteAdmin($id, $del_flag) {
        $db = DB::getInstance();
        $stmt = $db->prepare('UPDATE ADMIN SET del_flag = :del_flag where id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':del_flag', $del_flag, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function getInfor($email, $password) {

        $db = DB::getInstance();
        $del_flag = DEL_FLAG_ACTIVE;
        $stmt = $db->prepare('SELECT * FROM admin where email = :email '
                . 'AND password = :password and del_flag= :del_flag');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
        $stmt->execute();
        $list = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($list)) {
            return $list;
        } else {
            return [];
        }
    }

    public static function checkIdAdmin($id) {
        $db = DB::getInstance();
        $del_flag = DEL_FLAG_ACTIVE;
        
        $stmt = $db->prepare('SELECT id FROM admin '
                . 'where id = :id and del_flag = :del_flag');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':del_flag', $del_flag, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result > 0;
    }

}

?>