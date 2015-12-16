<?php
	session_start();
	$nogleid = $_GET['nogleid'];
	$db_server = "localhost";
	$db_brugernavn = "HIDDEN";
	$db_password = "HIDDEN";
	$db_dbnavn = "joha2514";
	$con = mysqli_connect($db_server, $db_brugernavn, $db_password, $db_dbnavn);

	if (($_SESSION["brugertype"] == "1") or ($_SESSION["brugertype"] == "2")) {
		//TJEK HVILKEN BRUGERTYPE DER SLETTES
		if ($_SESSION["brugertype"] == "2") {
			$result = mysqli_query($con, 'SELECT * from `joha2514`.`nyebrugere`');
			while ($row = mysqli_fetch_array($result)){
				if ($row["nogle-id"] == $nogleid) {
					if ($row["brugertype"] == "3") {
						mysqli_query($con, 'DELETE FROM `nyebrugere` WHERE `nogle-id`="' . $nogleid . '"');
						mysqli_close($con);
					}
				}
			}




		} else {
			mysqli_query($con, 'DELETE FROM `nyebrugere` WHERE `nogle-id`="' . $nogleid . '"');
			mysqli_close($con);
		}
	}
	header("Location: http://webhotel.herningsholm.dk/joha2514");
	die();
?>
