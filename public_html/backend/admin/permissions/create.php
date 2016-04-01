<?php

include('../header.php');
require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';

echo $security->generatePassword();
?>

<link rel="stylesheet" href="../../../assets/css/filetree.css" type="text/css" >
<div class='panel'>
    <h2>Create new folder permission</h2>
    
    <a href='index.php' class='btn'>View Folder permissions</a>
    <br><br>
    
    <form method='post' id="form">
        <div class="form-field">
            <input type="text" name="name" class="form-input" placeholder="Group" />
        </div>
        <div class="form-field">
            <input type="text" name="password" class="form-input" placeholder="Password" />
            <a href='javascript:randomPwd()'>Random Password</a>
        </div>
        <div class="form-field">
            <input type='button' class='btn blue' data-popup-open="popup-1" value='Select folders'>
            
            <div class="popup" data-popup="popup-1">
                <div class="popup-inner">
                    <h2>Select Folders / Files</h2>
                    <p class="checkedSoFar">There are 0 folders/files checked.</p>
                    <br />
                    <input type="button" data-popup-close="popup-1" class='btn' value="Done" />
                    <br><br>
                    
                    <div id="container"> </div>
                    <a class="popup-close" data-popup-close="popup-1" href="#">x</a>
                    
                </div>
            </div>
            
        </div>
        
        <div class="loading"></div>
        <div class="form-field helper"></div>
        
        <div class="form-field last">
            <input type="button" class="btn _saveBtn" value='Save' />
        </div>
    </form>
    
</div>

<?php

include('../footer.php');

?>

<script src="<?=$url?>/assets/js/formValidator.js"></script>    