<?php

require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    $response = [];
    
    $id = $security->makeSafe($_POST['id']);
    $name = $security->makeSafe($_POST['name']);
    $password = $security->makeSafe($_POST['password']);
        
    
    if(empty($name) || empty($password)){
        $response['status'] = '403';
        $response['message'] = 'Name and password cannot be blank.';
        
        echo json_encode($response);
        return;
    }
    
        
        if(dbClass::editPassword($id, $name, $password)){
            $response['status'] = '200';
            $response['message'] = 'Password has been successfully updated for '.$name.'.';
                

                if(isset($_POST['file'])){
                    $file = $_POST['file'];
                    


                    if(dbClass::query('DELETE FROM files WHERE password_id="'.$id.'"')){

                        foreach($file as $fl){
                        $filename = array_pop(explode('/', $fl));

                            if(dbClass::query('INSERT INTO files (password_id, file) VALUES ("'.$id.'", "'.$filename.'")')){
                                $response['status'] = '200';
                                $response['message'] = 'Password has been successfully updated for '.$name.'.';
                            } else {
                                $response['status'] = '500';
                                $response['message'] = 'Could not save the password.';
                            }

                        }

                    } else {
                        $response['status'] = '500';
                        $response['message'] = 'Could not edit files.';

                        echo json_encode($response);
                        return;
                    }
                    
                }
                
        } else {
            $response['status'] = '500';
            $response['message'] = 'Could not edit the user\'s permission.';

            echo json_encode($response);
            return;
        }
    
    
    echo json_encode($response);
    return;
    
}