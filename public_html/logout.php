<?php
ob_start();

setcookie('userId', "", 1, '/');
setcookie('loggedIn', "", 1, '/');

header('Location: index.php');

ob_end_flush();
?>