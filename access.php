<?php

require_once 'backend/classes/dbClass.php';
require_once 'backend/helpers/security.php';


$response = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $password = $security->makeSafe($_POST['password']);
    
    if(empty($password)){
        $response['status'] = '403';
        $response['message'] = 'Password cannot be blank.';
        
        echo json_encode($response);
        return;
    }
    
    $authentication = $security->loginFrontUser($password);
        
    if($authentication){
        
        setcookie('userId', $authentication['id'], 0);
        setcookie('loggedIn', true, 0);
        
        $response['status'] = '200';
        $response['message'] = 'Logged in successfully! Redirecting...';
        
    } else {
        $response['status'] = '403';
        $response['message'] = 'Details not found.';        
    }
    
    
    echo json_encode($response);
    return;
    
    
}