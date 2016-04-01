<?php

require_once '../../classes/dbClass.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    $query = dbClass::getPasswordById($id);
 
    if($query){

include('../header.php');
require_once '../../helpers/security.php';
require_once '../../helpers/php_file_tree_edit.php';
?>
<link rel="stylesheet" href="../../../assets/css/filetree.css" type="text/css" >

<div class='panel'>
    <h2>Edit <?=$query['name']?>'s permissions</h2>
    
    <a href='index.php' class='btn'>View Folder permissions</a>
    <br><br>
    
    <form method='post' id="form">
        <input type='hidden' name='id' value='<?=$_GET['id']?>' />
        <div class="form-field">
            <input type="text" name="name" class="form-input" value="<?=$query['name']?>" placeholder="Name" />
        </div>
        <div class="form-field">
            <input type="text" name="password" class="form-input" value="<?=$query['password']?>" placeholder="Password" />
            <a href='javascript:randomPwd()'>Random Password</a>
        </div>
        <div class="form-field">
            <input type='button' class='btn blue' data-popup-open="popup-1" value='Select folders'>
            
            <div class="popup" data-popup="popup-1">
                <div class="popup-inner">
                    <h2>Select Folders / Files</h2>
                    <p class="checkedSoFar">There are 0 folders/files checked.</p>
                    
                    <div id="container"> </div>
                    <a class="popup-close" data-popup-close="popup-1" href="#">x</a>
                    
                    <br /><br />
                    <input type="button" data-popup-close="popup-1" class='btn' value="Done" />
                </div>
            </div>
            
        </div>
        
        <div class="loading"></div>
        <div class="form-field helper"></div>
        
        <div class="form-field last">
            <input type="button" class="btn _saveEditBtn" value='Save' />
        </div>
    </form>
    
</div>

<?php

include('../footer.php');

?>

<script src="<?=$url?>/assets/js/formValidator.js"></script>    

<?php
} else {
    header('location: index.php');
}


} else {
    header('location: index.php');
}
?>