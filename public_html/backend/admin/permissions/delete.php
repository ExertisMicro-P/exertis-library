<?php

require_once '../../classes/dbClass.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
 
    if(dbClass::getPasswordById($id)){
        
        if(dbClass::deletePassword($id)){
            header('location: index.php');  
        } else {
            header('location: index.php');  
        }
        
    } else {
        header('location: index.php');  
    }
    
    
} else {
    header('location: index.php');
}