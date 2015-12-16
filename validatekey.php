<?php
$key = $_GET['key'];
$db_server = "localhost";
$db_brugernavn = "HIDDEN";
$db_password = "HIDDEN";
$db_dbnavn = "joha2514";
$con = mysqli_connect($db_server, $db_brugernavn, $db_password, $db_dbnavn);

$done = "no";

$result = mysqli_query($con, 'SELECT * from `joha2514`.`nyebrugere`');
while ($row = mysqli_fetch_array($result)){
	if(($row["nogle"] == $key) and ($row["ejer"] == "")) {
		$done = "yes";
	}
}
if ($done == "yes") {
	echo "true";
} else {
	echo "false";
}
?>
