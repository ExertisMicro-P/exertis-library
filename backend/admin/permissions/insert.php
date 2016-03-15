<?php

require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $response = [];
    
    $name = $security->makeSafe($_POST['name']);
    $password = $security->makeSafe($_POST['password']);
    
    
    if(!isset($_POST['file'])){
        $response['status'] = '403';
        $response['message'] = 'Select at least one folder.';
        
        echo json_encode($response);
        return;
    }
    
    $file = $_POST['file'];
    
    if(empty($name) || empty($password)){
        $response['status'] = '403';
        $response['message'] = 'Name, email and password cannot be blank.';
        
        echo json_encode($response);
        return;
    }
    
    if(dbClass::getPasswordFromPasswords($password)){
        $response['status'] = '403';
        $response['message'] = 'This password is already set up.';
        
        echo json_encode($response);
        return;
    }
            
        if(dbClass::savePassword($name, $password)){
            
            $pwdId = dbClass::getLastPasswordId()['id'];
            foreach($file as $fl){
                
                $filename = array_pop(explode('/', $fl));
                
                if(dbClass::query('INSERT INTO files (password_id, file) VALUES ("'.$pwdId.'", "'.$filename.'")')){
                    $response['status'] = '200';
                    $response['message'] = 'Password has been successfully set up for '.$name.'.';
                } else {
                    $response['status'] = '500';
                    $response['message'] = 'Could not save the password.';
                }

            }
            
        }
    
    
    echo json_encode($response);
    return;
    
}