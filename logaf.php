<?php
	session_start();
	session_unset();
	session_destroy(); 
	header("Location: http://webhotel.herningsholm.dk/joha2514");
	die();
?>