<?php
ob_start();

setcookie('username', "", 1, '/backend/');
setcookie('userId', "", 1, '/backend/');
setcookie('loggedInAdmin', "", 1, '/backend/');

header('Location: ../index.php');

ob_end_flush();
?>