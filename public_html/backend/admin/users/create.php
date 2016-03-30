<?php

include('../header.php');
require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';
?>

<link rel="stylesheet" href="../../../assets/css/filetree.css" type="text/css" >
<div class='panel'>
    <h2>Create new user</h2>
    
    <a href='index.php' class='btn'>View users</a>
    <br><br>
    
    <form method='post' id="form">
        <div class="form-field">
            <input type="text" name="username" class="form-input" placeholder="Username" />
        </div>
        <div class="form-field">
            <input type="text" name="email" class="form-input" placeholder="Email" />
        </div>
        <div class="form-field">
            <input type="password" name="password" class="form-input" placeholder="Password" />
        </div>
        
        <div class="loading"></div>
        <div class="form-field helper"></div>
        
        <div class="form-field last">
            <input type="button" class="btn _saveUserBtn" value='Save' />
        </div>
    </form>
    
</div>

<?php

include('../footer.php');

?>

<script src="<?=$url?>/assets/js/formValidator.js"></script>    