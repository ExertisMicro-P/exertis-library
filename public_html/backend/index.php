<?php

if(isset($_COOKIE['loggedInAdmin']) && $_COOKIE['loggedInAdmin'] == true){
    
    header('Location: admin/index.php');
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>Exertis Library</title>


	<!-- Include our stylesheet -->
	<link href="/assets/css/styles.css" rel="stylesheet"/>

</head>
<body>
        <div class="overlay"></div>

        <div class="login">
            <h1>Backend Login</h1>
            
            <form id='login' method="post">
                <div class="form-field">
                    <input type="text" name="username" class="form-input" placeholder="Username" />
                </div>
                <div class="form-field">
                    <input type="password" name="password" class="form-input" placeholder="Password" />
                </div>
                
                <div class="form-field helper"></div>
                
                <div class="form-field">
                    <input type="button" class="btn _loginBtn" value="Login">
                </div>
            </form>
        </div>
	<footer>
            <!--
        <a class="tz" href="http://tutorialzine.com/2014/09/cute-file-browser-jquery-ajax-php/">Cute File Browser with jQuery, AJAX and PHP</a>
        <div id="tzine-actions"></div>
        <span class="close"></span>
            -->
    </footer>

	<!-- Include our script files -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script src="../assets/js/loginScript.js"></script>

</body>
</html>
