<?php

require_once '../../classes/dbClass.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    $query = dbClass::getUserById($id);
 
    if($query){

include('../header.php');
require_once '../../helpers/security.php';
?>

<div class='panel'>
    <h2>Edit <?=$query['username']?>'s profile</h2>
    
    <a href='index.php' class='btn'>View users</a>
    <br><br>
    
    <form method='post' id="form">
        <input type='hidden' name='id' value='<?=$_GET['id']?>' />
        <div class="form-field">
            <input type="text" name="username" class="form-input" value="<?=$query['username']?>" placeholder="Username" />
        </div>
        <div class="form-field">
            <input type="text" name="email" class="form-input" value="<?=$query['email']?>" placeholder="Email" />
        </div>
        <div class="form-field">
            <input type="password" name="password" class="form-input" value="" placeholder="Password" />
            <p style="color:#999">Leave it empty if no changes required.</p>
        </div>
        
        <div class="loading"></div>
        <div class="form-field helper"></div>
        
        <div class="form-field last">
            <input type="button" class="btn _saveEditUserBtn" value='Save' />
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