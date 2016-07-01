<?php

if(isset($_COOKIE['loggedIn']) && $_COOKIE['loggedIn'] == true){
    
    require_once 'backend/classes/dbClass.php';
    
    $userId = $_COOKIE['userId'];
    $loggedIn = $_COOKIE['loggedIn'];
    
    if(!dbClass::getPasswordById($userId)){
        header('Location: index.html');
    }
    
} else {
    
    header('Location: index.html');
    
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
	<link href="assets/css/styles.css" rel="stylesheet"/>

</head>
<body>
        <div class="overlay"></div>
        
        
        <div class="filemanager">
        <img src="assets/img/exertis-logo.png" />
        <h1 class='link' onclick='window.location="logout.php"'>Logout</h1>

		<div class="search">
			<input type="search" placeholder="Find a file.." />
		</div>

		<div class="breadcrumbs"></div>

        <form id="zipinfo" action="zipup.php" method="post">
            <input type="hidden" name="files" />
            <input type="submit" value="Download Zip File" />
        </form>


		<ul class="data"></ul>

		<div class="nothingfound">
			<div class="nofiles"></div>
			<p>No files here.</p>
                        <p><small>IE User? Press F5 to refresh</small></p>
		</div>

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
	<script src="assets/js/script.js"></script>
        <script src="assets/js/jquery.simplemodal.1.4.4.min.js"></script>

</body>
</html>
