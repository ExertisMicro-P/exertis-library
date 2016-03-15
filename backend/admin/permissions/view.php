<?php

require_once '../../classes/dbClass.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    $query = dbClass::getPasswordById($id);
 
    if($query){

include('../header.php');
require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';
?>

<div class='panel'>
    <h2><?=$query['name']?>'s permission</h2>
    
    <a href='index.php' class='btn'>View Folder Permissions</a>
    &nbsp;&nbsp;&nbsp;
    <a href='edit.php?id=<?=$id?>' class='btn view'>Edit permission</a>
    &nbsp;&nbsp;&nbsp;
    <a href='delete.php?id=<?=$id?>' class='btn delete'>Delete permission</a>
    <br><br>
    
    <table class='table' style='width: 50%;margin:auto' align='center'>
        <tr>
            <td style='text-align:center'>Name</td>
            <td style='text-align:center'><?=$query['name']?></td>
        </tr>
        <tr>
            <td style='text-align:center'>Password</td>
            <td style='text-align:center'><?=$query['password']?></td>
        </tr>
        <tr>
            <td style='text-align:center'>Created</td>
            <td style='text-align:center'><?=$query['created']?></td>
        </tr>
        <tr>
            <td colspan='2'>
                <h3>Folders can be accessed</h3>
                <?php
                    foreach(dbClass::getAccessableFiles($id) as $files){
                        
                        echo $files['file'] . '<br><br>';

                    }
                ?>
            </td>
        </tr>
    </table>
    
    
            
</div>

<?php

include('../footer.php');

?>


    <?php
    } else {
        header('location: index.php');
    }
    
    
} else {
    header('location: index.php');
}