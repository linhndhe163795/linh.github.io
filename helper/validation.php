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
        $avatar = Admin::checkUploadFile();
        if (!$avatar) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";

            $result['messages']['avatar'] = "Choose Image";
        }

        if (empty($data['name'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";


            $result['messages']['name'] = 'Name can not be blank.';
        }

        if (empty($data['email'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['email'] = 'Email can not be blank.';
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['email'] = 'Email is invalid';
        } else if (Admin::checkDuplicateEmail($data['email'], $data['id'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['name'] = $data['name'];
            $result['valid']['email'] = $data['email'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['email'] = 'Email is exist';
        }

        if (empty($data['password'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['password'] = 'Password can not be blank';
        }

        if (empty($data['verifyPassword'])) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['verifyPassword'] = 'Verify Password can not be blank';
        }

        if ($data['password'] !== $data['verifyPassword']) {
            //Truyền lại giá trị vừa nhập
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            isset($data['active']) ? $result['valid']['active'] = $data['active'] : "";

            $result['messages']['password'] = 'Password not match';
        }

        if (empty($data['role_type'])) {
            //Truyền lại giá trị vừa nhập
            isset($data['role_type']) ? $result['valid']['role_type'] = $data['role_type'] : "";
            $result['valid']['email'] = $data['email'];
            $result['valid']['name'] = $data['name'];

            $result['messages']['avatar'] = "Choose Image";
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
