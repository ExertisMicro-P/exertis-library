<?php

require_once 'classes/dbClass.php';
require_once 'helpers/security.php';


$response = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $userName = $security->makeSafe($_POST['username']);
    $password = $security->makeSafe($_POST['password']);
    
    if(empty($userName) || empty($password)){
        $response['status'] = '403';
        $response['message'] = 'Username and password cannot be blank.';
        
        echo json_encode($response);
        return;
    }
    
    $password = $security->hashPwd($password);
    $authentication = $security->loginUser($userName, $password);
            
    if($authentication){
        
        setcookie('userId', $authentication['id'], 0);
        setcookie('username', $authentication['username'], 0);
        setcookie('loggedInAdmin', true, 0);
        
        $response['status'] = '200';
        $response['message'] = 'Logged in successfully';
        
    } else {
        $response['status'] = '403';
        $response['message'] = 'Details not found.';        
    }
    
    
    echo json_encode($response);
    return;
    
    
}