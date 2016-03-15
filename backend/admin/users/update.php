<?php

require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $response = [];
    
    $id = $security->makeSafe($_POST['id']);
    $username = $security->makeSafe($_POST['username']);
    $email = $security->makeSafe($_POST['email']);
    $password = $security->makeSafe($_POST['password']);
        
    
    if(empty($username) || empty($email)){
        $response['status'] = '403';
        $response['message'] = 'Name and email cannot be blank.';
        
        echo json_encode($response);
        return;
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $response['status'] = '403';
        $response['message'] = 'Invalid email address';
        
        echo json_encode($response);
        return;
    }
    
    if(!empty($password) && strlen($password) < 4) {
        $response['status'] = '403';
        $response['message'] = 'Password should be at least 4 characters.';
        
        echo json_encode($response);
        return;
    }
    
    if(empty($password)){
    
        if(dbClass::editUser($id, $username, $email)){
            $response['status'] = '200';
            $response['message'] = 'User has been successfully '.$username.'.';
        } else {
            $response['status'] = '500';
            $response['message'] = 'Could not edit the user.';
        }
        
    } else {
        
        $password = $security->hashPwd($password);
        
        if(dbClass::editUserWithPwd($id, $username, $email, $password)){
            $response['status'] = '200';
            $response['message'] = 'User has been successfully '.$username.'.';
        } else {
            $response['status'] = '500';
            $response['message'] = 'Could not edit the user.';
        }
        
    }
    
    
    echo json_encode($response);
    return;
    
}