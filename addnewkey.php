<?php
	session_start();
	$brugertype = $_GET['brugertype'];
	$db_server = "localhost";
	$db_brugernavn = "joha2514";
	$db_password = "HIDDEN";
	$db_dbnavn = "HIDDEN";
	$con = mysqli_connect($db_server, $db_brugernavn, $db_password, $db_dbnavn);


	if (!($_SESSION["brugertype"] == "")) {
		if ($brugertype == "2") {
			if ($_SESSION["brugertype"] == "1") {
				$nogle = rand(10000000000000,99999999999999);
				mysqli_query($con, 'INSERT INTO `nyebrugere`(`nogle`, `brugertype`) VALUES (' . $nogle . ',2)');
				mysqli_close($con);
			}
		} else {
			$nogle = rand(10000000000000,99999999999999);
			mysqli_query($con, 'INSERT INTO `nyebrugere`(`nogle`, `brugertype`) VALUES (' . $nogle . ',3)');
			mysqli_close($con);
		}
	}
	header("Location: http://webhotel.herningsholm.dk/joha2514");
	die();
?>
