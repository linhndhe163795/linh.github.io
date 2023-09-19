<?php

require_once 'models/admin.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Validation {

    static function validateCreateAdmin($data) {
        $result = [
            'status' => false,
            'messages' => []
        ];
        $avatar = Admin::checkUploadFile();
        if (!$avatar) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['role_type'] = $data['role_type'];
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];

            $result['messages']['avatar'] = "Choose Image";
        }
        if (empty($data['name'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['role_type'] = $data['role_type'];

            $result['messages']['name'] = 'Name can not be blank.';
        }
        if (empty($data['email'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['name'] = $data['name'];
            $result['valid']['role_type'] = $data['role_type'];

            $result['messages']['email'] = 'Email can not be blank.';
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['role_type'] = $data['role_type'];
            $result['valid']['name'] = $data['name'];

            $result['messages']['email'] = 'Email is invalid';
        } else if (Admin::checkDuplicateEmail($data['email'], 0)) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['name'] = $data['name'];
            $result['valid']['role_type'] = $data['role_type'];

            $result['messages']['email'] = 'Email is exist';
        }
        if (empty($data['password'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['role_type'] = $data['role_type'];
            $result['messages']['password'] = 'Password can not be blank';
        }
        if (empty($data['verifyPassword'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['role_type'] = $data['role_type'];

            $result['messages']['verifyPassword'] = 'Verify Password can not be blank';
        }
        if (empty($data['role_type'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            //Hiển thị thông báo lỗi
            $result['messages']['role_type'] = 'Choose Role_Type';
        }
        if ($data['password'] !== $data['verifyPassword']) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['role_type'] = $data['role_type'];

            $result['messages']['password'] = 'Password not match';
        }

        if (empty($result['messages'])) {
            $result['status'] = true;
        }
        return $result;
    }

    static function validateEdit($data) {
        $result = [
            'status' => FALSE,
            'messages' => []
        ];
        $avatar = Admin::checkUploadFile();
        if (!$avatar) {
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['active'] = $data['active'];

            $result['messages']['avatar'] = "Choose Image";
        }if (empty($data['name'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['active'] = $data['active'];

            $result['messages']['name'] = 'Name can not be blank.';
        }
        if (empty($data['email'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['name'] = $data['name'];
            $result['valid']['active'] = $data['active'];

            $result['messages']['email'] = 'Email can not be blank.';
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['name'] = $data['name'];
            $result['valid']['active'] = $data['active'];


            $result['messages']['email'] = 'Email is invalid';
        } else if (Admin::checkDuplicateEmail($data['email'], $data['id'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['name'] = $data['name'];
            $result['valid']['active'] = $data['active'];

            $result['messages']['email'] = 'Email is exist';
        }
        if (empty($data['password'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['active'] = $data['active'];

            $result['messages']['password'] = 'Password can not be blank';
        }
        if (empty($data['verifyPassword'])) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['active'] = $data['active'];

            $result['messages']['verifyPassword'] = 'Verify Password can not be blank';
        }
        if ($data['password'] !== $data['verifyPassword']) {
            //Truyền lại biến nếu như nhập đúng
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            $result['valid']['active'] = $data['active'];

            $result['messages']['password'] = 'Password not match';
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
