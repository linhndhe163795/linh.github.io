<?php

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

//    function MethodEditAdmin($id, $name, $password, $email, $avatar, $del_flag) {
//        $this->id = $id;
//        $this->name = $name;
//        $this->password = $password;
//        $this->email = $email;
//        $this->avatar = $avatar;
//        $this->del_flag = $del_flag;
//    }

    static function checkAccount($email, $password) {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT email, password FROM admin WHERE '
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

    static function searchbyNameandEmail($email, $name, $start, $end) {
        $db = DB::getInstance();
        $list = [];
        $stmt = $db->prepare('SELECT id, name, email, password, role_type, avatar,'
                . 'del_flag FROM admin WHERE email LIKE :email AND name LIKE '
                . ':name and del_flag =0  LIMIT  :start, :end');
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
        $stmt = $db->prepare('SELECT COUNT(ID) FROM admin where email like :email and name like :name and del_flag = 0');
        $email = '%' . $email . '%';
        $name = '%' . $name . '%';
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
//        dd($count);
        return $count;
    }

    public static function detailAdmin($id) {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT id,name,email,password,avatar,del_flag from admin where id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($list)) {
//            dd($list);
            return $list;
        } else {
            return []; // Trả về mảng rỗng nếu không tìm thấy dữ liệu
        }
    }

    public static function editAdmin($admin = array()) {
        $db = DB::getInstance();
        $pass = md5($admin[2]);
        $stmt = $db->prepare('UPDATE admin SET name = :name, email = :email, password = :password, avatar = :avatar, del_flag = :del_flag WHERE id = :id');

        $stmt->bindParam(':name', $admin[0], PDO::PARAM_STR);
        $stmt->bindParam(':email', $admin[1], PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':avatar', $admin[3], PDO::PARAM_STR);
        $stmt->bindParam(':del_flag', $admin[4], PDO::PARAM_INT);
        $stmt->bindParam(':id', $admin[5], PDO::PARAM_INT);
//        dd($admin);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function createNewAccount($account) {
        $db = DB::getInstance();
//        $passwordHash = password_hash($account['password'], PASSWORD_DEFAULT);
        $passwordmd5 = md5($account['password']);

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
                . 'WHERE email = :email and del_flag = 0 and id != :id');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteAdmin($id, $del_flag) {
        $db = DB::getInstance();
        $stmt = $db->prepare('UPDATE ADMIN SET del_flag = :del_flag where id = :id');

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
        $stmt = $db->prepare('SELECT * FROM admin where email = :email '
                . 'AND password = :password and del_flag=0');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        $list = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($list)) {
//            dd($list);
            return $list;
        } else {
            return []; // Trả về mảng rỗng nếu không tìm thấy dữ liệu
        }
    }

    public static function checkUploadFile() {
        if (isset($_FILES["avatar"]) && !$_FILES["avatar"]["error"]) {
            $destinationPath = 'C:/xampp/htdocs/ProjectPHP/views/pages/media/' . $_FILES["avatar"]["name"];

            // Kiểm tra nếu tệp là ảnh
            $imageInfo = getimagesize($_FILES["avatar"]["tmp_name"]);
            if ($imageInfo !== false) {
                // Kiểm tra định dạng của ảnh (PNG hoặc không)
                $imageMimeType = $imageInfo['mime'];
                if ($imageMimeType === 'image/png' || $imageMimeType === 'image/jpeg' || $imageMimeType === 'image/jpg' || $imageMimeType === 'image/gif') {
                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $destinationPath)) {
                        // Trả về tên tệp ảnh nếu thành công
                        return $_FILES["avatar"]["name"];
                    } else {
                        echo "";
                    }
                } else {
                    echo "";
                }
            } else {
                echo "";
            }
        } else {
            echo "";
        }
        return null;
    }

    public static function checkIdAdmin($id) {
        $db = DB::getInstance();
        $stmt = $db->prepare('SELECT id FROM admin '
                . 'where id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>