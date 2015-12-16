<?php
	session_start();
	$brugertype = $_GET['brugertype'];
	$nogleid = $_GET['nogleid'];
	$db_server = "localhost";
	$db_brugernavn = "joha2514";
	$db_password = "HIDDEN";
	$db_dbnavn = "HIDDEN";
	$con = mysqli_connect($db_server, $db_brugernavn, $db_password, $db_dbnavn);


	if ($_SESSION["brugertype"] == "1") {
		$result = mysqli_query($con, 'SELECT * from `joha2514`.`nyebrugere`');
		while ($row = mysqli_fetch_array($result)){
			if ($row["nogle-id"] == $nogleid) {
				if ($row["ejer"] == "") {
					mysqli_query($con, 'UPDATE `nyebrugere` SET `brugertype`=' . $brugertype . ' WHERE `nogle-id`="' . $nogleid . '"');
					mysqli_close($con);
				}
			}
		}
	}
	header("Location: http://webhotel.herningsholm.dk/joha2514");
	die();
?>
