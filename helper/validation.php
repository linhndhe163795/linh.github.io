<?php

require_once 'models/admin.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Validation {

    static function validateInput($data) {
        $result = [
            'status' => false,
            'messages' => []
        ];
        $data['id'] = isset($data['id']) ? $data['id'] : "";
        if (empty($data['name'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['name'] = 'Name can not be blank.';
            //kiểm tra độ dài 
        } else if (strlen($data['name']) > MAX_LENGTH || strlen($data['name']) < MIN_LENGTH) {
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['name'] = 'Greater than 3 characters and not exceeding 128 characters.';
        }

        if (empty($data['email'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['email'] = 'Email can not be blank.';
            //kiểm tra định dạng
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            //Truyền lại giá trị vừa nhập
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['email'] = 'Email is invalid';
            //kiểm tra email tồn tại trong database
        } else if (Admin::checkDuplicateEmail($data['email'], $data['id'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['email'] = 'Email is exist';
            //kiểm tra độ dài của email
        } else if (strlen($data['email']) > MAX_LENGTH || strlen($data['email']) < MIN_LENGTH) {
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['email'] = 'Greater than 3 characters and not exceeding 128 characters.';
        }

        if (empty($data['password'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['password'] = 'Password can not be blank';
        } else if (strlen($data['password']) > MAX_LENGTH_PASSWORD || strlen($data['password']) < MIN_LENGTH) {
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['password'] = 'Greater than 3 characters and not exceeding 100 characters.';
        }


        if (empty($data['verifyPassword'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['verifyPassword'] = 'Verify Password can not be blank';
        }

        if ($data['password'] !== $data['verifyPassword']) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['avatar'] = $data['avatar'];
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['password'] = 'Password not match';
        }

        if (empty($data['role_type'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['avatar'] = $data['avatar'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];

            $result['messages']['role_type'] = "Choose Role_Type";
        }




        if (empty($result['messages'])) {
            $result['status'] = true;
        }
        return $result;
    }

    static function checkUploadFileForEdit($data, $detail) {
        $currentFile = __FILE__;
        $currentDirectory = dirname($currentFile);

        if (!isset($_FILES["avatar"]) || $_FILES["avatar"]["error"]) {
            // Người dùng không chọn tệp ảnh mới hoặc có lỗi, sử dụng ảnh cũ
            return isset($detail[0]['avatar']) ? $detail[0]['avatar'] : $data['avatar'];
        }

        $destinationPath = $currentDirectory . '/../views/pages/media/' . $_FILES["avatar"]["name"];

        $imageInfo = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($imageInfo == false) {
            // Kiểm tra không phải là hình ảnh hợp lệ
            return $data['avatar'];
        }

        $imageMimeType = $imageInfo['mime'];
        if (!in_array($imageMimeType, ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'])) {
            // Kiểm tra không phải là định dạng hình ảnh hợp lệ
            return $data['avatar'];
        }

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $destinationPath)) {
            // Trả về tên tệp ảnh nếu thành công
            return $_FILES["avatar"]["name"];
        }

        // Trả về giá trị mặc định nếu có lỗi khi tải lên
        return $data['avatar'];
    }

    static function validateImageForEdit($data) {
        $result = [
            'status' => false,
            'messages' => []
        ];
        $data['id'] = isset($data['id']) ? $data['id'] : "";
        $detailsAdmin = Admin::detailAdmin($data['id']);
        $detailsUser = User::detailUser($data['id']);
//        $id = isset($detailsAdmim) ? $detailsAdmim : isset($detailsUser) ? $detailsUser : NULL;
        if (empty($detailsAdmin)) {
            $id = $detailsUser;
        } else if (empty($detailsUser)) {
            $id = $detailsAdmin;
        }
        $avatar = Validation::checkUploadFileForEdit($data['avatar'], $id);
        if (!$avatar) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['avatar'] = $data['avatar'];
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            $result['messages']['avatar'] = "Invalid image format. Only PNG and GIF files are allowed.";
        }
        if (empty($result['messages'])) {
            $result['status'] = true;
        }
        return $result;
    }

    static function checkUploadFileForCreate() {
        $currentFile = __FILE__;
        $currentDirectory = dirname($currentFile);

        if (!isset($_FILES["avatar"]) || $_FILES["avatar"]["error"]) {
            return isset($_SESSION['previousAvatar']) ? $_SESSION['previousAvatar'] : NULL;
        }

        $destinationPath = $currentDirectory . '/../views/pages/media/' . $_FILES["avatar"]["name"];

        $imageInfo = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($imageInfo == false) {
            return;
        }

        $imageMimeType = $imageInfo['mime'];
        if (!in_array($imageMimeType, ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'])) {
            return;
        }

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $destinationPath)) {
            return $_FILES["avatar"]["name"];
        }

        return;
    }

    static function validateImageForCreate($data) {
        $result = [
            'status' => false,
            'messages' => []
        ];
        $data['avatar'] = Validation::checkUploadFileForCreate();
        if (!$data['avatar']) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            $result['messages']['avatar'] = "Invalid image format. Only PNG and GIF files are allowed.";
        }
        if (empty($result['messages'])) {
            $result['status'] = true;
        }
        return $result;
    }

    static function validateLogin($data) {
        $result = [
            'status' => FALSE,
            'messages' => []
        ];
        if (empty($data['email'])) {
            $result['messages']['email'] = 'Name can not be blank.';
        }
        if (empty($data['password'])) {
            $result['valid']['email'] = $data['email'];
            $result['messages']['password'] = 'Password can not be blank.';
        }

        if (empty($result['messages'])) {
            $result['status'] = true;
        }
        return $result;
    }

}
