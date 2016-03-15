<?php

include('../header.php');
require_once '../../classes/dbClass.php';

?>

<div class='panel'>
    <h2>Users</h2>
    
    <a href='create.php' class='btn'>New User</a>
    
    <table class='table' width='100%' cellpadding='3' cellspacing='3'>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Last Login</th>
            <th>Login IP</th>
            <th>&nbsp;</th>
        </tr>
        <?php
            $users = dbClass::fetchAllUsers();
            foreach($users as $user){
        ?>
        <tr>
            <td><?=$user['id']?></td>
            <td><?=$user['username']?></td>
            <td><?=$user['email']?></td>
            <td><?=$user['last_login']?></td>
            <td><?=$user['login_ip']?></td>
            <td>
                <a href='view.php?id=<?=$user['id']?>' class='action-btn view' title='View'>&#10070;</a>
                <a href='edit.php?id=<?=$user['id']?>' class='action-btn edit' title='Edit'>&#9998;</a>
                <a href='javascript:if(confirm("Are you sure?")){ window.location="delete.php?id=<?=$user['id']?>"; }' class='action-btn delete' title='Delete'>&#10006;</a>
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