<?php

require_once '../../classes/dbClass.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
 
    if(dbClass::getUserById($id)){
        
        if(dbClass::deleteUser($id)){
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