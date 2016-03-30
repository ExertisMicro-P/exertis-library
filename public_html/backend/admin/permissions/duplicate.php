<?php

require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    
    $values = dbClass::getPasswordById($id);
    $folders = dbClass::getAccessableFiles($values['id']);
    
    if(dbClass::savePassword($values['name'], $values['password'])){
        
        $pwdId = dbClass::getLastPasswordId()['id'];
        
        
        foreach($folders as $fl){

            $filename = array_pop(explode('/', $fl['file']));

            if(dbClass::query('INSERT INTO files (password_id, file) VALUES ("'.$pwdId.'", "'.$filename.'")')){
                header('Location: index.php');
            } else {
                header('Location: index.php');
            }

        }
        
    } else {
        header('Location: index.php');
    }
    
    var_dump($values);
 
    
}