<?php

include('../header.php');
require_once '../../classes/dbClass.php';

?>

<div class='panel'>
    <h2>Folder Permissions</h2>
    
    <a href='create.php' class='btn'>New folder permission</a>
    
    <table class='table' width='100%' cellpadding='5' cellspacing='0'>
        <tr>
            <th>ID</th>
            <th>Group</th>
            <th>Password</th>
            <th>Set up By</th>
            <th>Created</th>
            <th>&nbsp;</th>
        </tr>
        <?php
            $passwords = dbClass::fetchAllPasswords();
            foreach($passwords as $password){
            
            $adminName = dbClass::getUserById($password['admin_id'])['username'];
        ?>
        <tr>
            <td><?=$password['id']?></td>
            <td><?=$password['name']?></td>
            <td><?=$password['password']?></td>
            <td><?=$adminName?></td>
            <td><?=$password['created']?></td>
            <td>
                <a href='javascript:if(confirm("Do you really want to duplicate it?")){ window.location="duplicate.php?id=<?=$password['id']?>"; }' class='action-btn duplicate' title='Duplicate'>&#9903;</a>
                <a href='view.php?id=<?=$password['id']?>' class='action-btn view' title='View'>&#10070;</a>
                <a href='edit.php?id=<?=$password['id']?>' class='action-btn edit' title='Edit'>&#9998;</a>
                <a href='javascript:if(confirm("Are you sure?")){ window.location="delete.php?id=<?=$password['id']?>"; }' class='action-btn delete' title='Delete'>&#10006;</a>
            </td>
        </tr>
        <?php
            }
        ?>
    </table>
    
</div>

<?php

include('../footer.php');

?>