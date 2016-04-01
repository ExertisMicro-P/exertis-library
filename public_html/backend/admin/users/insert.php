<?php

require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $response = [];
    
    $username = $security->makeSafe($_POST['username']);
    $email = $security->makeSafe($_POST['email']);
    $password = $security->makeSafe($_POST['password']);
    
    if(empty($username) || empty($email) || empty($password)){
        $response['status'] = '403';
        $response['message'] = 'Name, email and password cannot be blank.';
        
        echo json_encode($response);
        return;
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $response['status'] = '403';
        $response['message'] = 'Invalid email address';
        
        echo json_encode($response);
        return;
    }
    
    if(dbClass::getEmailFromUsers($email)){
        $response['status'] = '403';
        $response['message'] = 'This user already has a password.';
        
        echo json_encode($response);
        return;
    }

    $password = $security->hashPwd($password);
    
    if(dbClass::saveUser($username, $email, $password)){
        $response['status'] = '200';
        $response['message'] = 'New user created: '.$username.'.';            
    } else {
        $response['status'] = '500';
        $response['message'] = 'Could not save user.';
    }


    echo json_encode($response);
    return;
    
}