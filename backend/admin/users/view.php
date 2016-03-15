<?php

require_once '../../classes/dbClass.php';

if(isset($_GET['id'])){
    
    $id = $_GET['id'];
    $query = dbClass::getUserById($id);
 
    if($query){

include('../header.php');
require_once '../../classes/dbClass.php';
require_once '../../helpers/security.php';

?>

<div class='panel'>
    <h2><?=$query['username']?>'s profile</h2>
    
    <a href='index.php' class='btn'>View Users</a>
    &nbsp;&nbsp;&nbsp;
    <a href='edit.php?id=<?=$id?>' class='btn view'>Edit user</a>
    &nbsp;&nbsp;&nbsp;
    <a href='javascript:if(confirm("Are you sure?")){ window.location="delete.php?id=<?=$id?>"; }' class='btn delete'>Delete user</a>
    <br><br>
    
    <table class='table' style='width: 50%;margin:auto' align='center'>
        <tr>
            <td style='text-align:center'>Username</td>
            <td style='text-align:center'><?=$query['username']?></td>
        </tr>
        <tr>
            <td style='text-align:center'>Email</td>
            <td style='text-align:center'><?=$query['email']?></td>
        </tr>
        <tr>
            <td style='text-align:center'>Last Login</td>
            <td style='text-align:center'><?=$query['last_login']?></td>
        </tr>
        <tr>
            <td style='text-align:center'>Login IP</td>
            <td style='text-align:center'><?=$query['login_ip']?></td>
        </tr>
    </table>
    <br><br>
    
    <h2>Permissions created by <?=$query['username']?></h2>
    
    <table class='table' style='width: 100%;margin:auto' align='center'>
        <tr>
            <th style='text-align:center'>ID</th>
            <th style='text-align:center'>Name</th>
            <th style='text-align:center'>Password</th>
            <th style='text-align:center'>Created</th>
            <th>&nbsp;</th>
        </tr>
        <?php
            foreach(dbClass::getPasswordsByAdminId($id) as $password) {
        ?>
        <tr>
            <td style='text-align:center'><?=$password['id']?></td>
            <td style='text-align:center'><?=$password['name']?></td>
            <td style='text-align:center'><?=$password['password']?></td>
            <td style='text-align:center'><?=$password['created']?></td>
            <td>
                <a href='/backend/admin/permissions/view.php?id=<?=$password['id']?>' class='action-btn view' title='View'>&#10070;</a>
                <a href='/backend/admin/permissions/edit.php?id=<?=$password['id']?>' class='action-btn edit' title='Edit'>&#9998;</a>
                <a href='javascript:if(confirm("Are you sure?")){ window.location="/backend/admin/permissions/delete.php?id=<?=$password['id']?>"; }' class='action-btn delete' title='Delete'>&#10006;</a>
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


    <?php
    } else {
        header('location: index.php');
    }
    
    
} else {
    header('location: index.php');
}