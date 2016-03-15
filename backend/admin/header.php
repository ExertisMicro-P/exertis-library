<?php

if(isset($_COOKIE['loggedInAdmin']) && $_COOKIE['loggedInAdmin'] == true){
    
    $userId = $_COOKIE['userId'];
    $userName = $_COOKIE['username'];
    $loggedIn = $_COOKIE['loggedInAdmin'];
    
} else {
    
    header('Location: ../index.php');
    
}

$url = 'http://'.$_SERVER['SERVER_NAME'];

?>

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>Exertis Library</title>


	<!-- Include our stylesheet -->
	<link href="<?=$url?>/assets/css/styles.css" rel="stylesheet"/>
	<link href="<?=$url?>/assets/css/directorylist.css" rel="stylesheet"/>

</head>
<body>
        <div class="overlay"></div>
                
        <div class='nav'>
            <h2 class='brand' onclick='window.location="/backend/admin/index.php"'>Exertis Library Backend</h2>
                <ul class='nav-ul right' data-status=''>
                    <li><a <?php echo($_SERVER['SCRIPT_NAME']=='/backend/admin/index.php')? 'class="active"' : null; ?> href='/backend/admin/index.php'>Home</a></li>
                    <li><a <?php echo($_SERVER['SCRIPT_NAME']=='/backend/admin/users/index.php')? 'class="active"' : null; ?> href='/backend/admin/users'>Users</a></li>
                    <li><a <?php echo($_SERVER['SCRIPT_NAME']=='/backend/admin/permissions/index.php')? 'class="active"' : null; ?> href='/backend/admin/permissions'>Folder permissions</a></li>
                    <li><a href='/backend/admin/logout.php'>Logout (<?=$userName?>)</a></li>
                </ul>
            <a class="toggle-nav right" href="#">&#9776;</a>
        </div>