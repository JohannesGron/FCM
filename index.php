<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>
			Home | FC Midtjylland
		</title>
		<link rel="shortcut icon" href="icon.png">
		<link rel="stylesheet" type="text/css" href="index.css"/>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
		<link rel="stylesheet" type="text/css" href="css/tooltipster-light.css"/>
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	    <script type="text/javascript" src="js/jquery-1.7.0.min.js"></script>
	    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
  		<script type="text/javascript" src="js/jquery-ui.js"></script>
	</head>
	<body>
    	<div id="wrapper">

				<div id="banner">
					<h1>FC Midtjylland</h1>
				</div>

				<div id="menulinje">

					<a href="index.php">

						<div id="hjem" align="center">
							<span>
								Hjem
							</span>
						</div>

					</a>


					<a href="#">

						<div id="omos" align="center">
							<span>
								Om os
							</span>
						</div>

					</a>


					<a href="#">

						<div id="medlemmere" align="center">
							<span>
								Medlemmere
							</span>
						</div>

					</a>



					<a href="#" onclick="loggg()">

						<div id="login" align="center">
							<span id="logtekst">Log ind</span>
						</div>

					</a>

				</div>

		</div<
	</body>
</html>




<?php
session_start();


if (($_SESSION["brugertype"]== "1") or ($_SESSION["brugertype"]== "2")) {

$db_server = "localhost";
$db_brugernavn = "HIDDEN";
$db_password = "HIDDEN";
$db_dbnavn = "joha2514";
$con = mysqli_connect($db_server, $db_brugernavn, $db_password, $db_dbnavn);

//Basictable
$basictabel = <<<tekst
	  <table style="margin-left:20px;">
		<caption>Medlems-nøgler</caption>
	  <tr>
	    <th>Nøgle-id</th>
	    <th>Nøgle</th>
	    <th>Brugertype</th>
	    <th>Ejer</th>
	    <th></th>
	  </tr>
tekst;


//Skriv tabel ud -------------------------------------------------------------------------------------------------------------------------------------------------
	$result = mysqli_query($con, 'SELECT * from `joha2514`.`nyebrugere`');
	while ($row = mysqli_fetch_array($result)){
		if(($row["brugertype"] == "2") and ($_SESSION["brugertype"]== "2")) {
			continue;
		}
		if((!($row["ejer"] == "")) and ($_SESSION["visregi"] == "")) {
			continue;
		}
		if($row["brugertype"] == "1") {
			continue;
		}
		$kolonne = <<<tekst
			<tr>
			    <td>nogle-id</td>
			    <td id="jepyea">nogle</td>
			    <td>brugertype</td>
			    <td>ejer</td>
			    <td>asdasdasdasd</td>
			</tr>
tekst;

//Nogle-id
$kolonne = str_replace("nogle-id",$row['nogle-id'],$kolonne);

//Nogle
$kolonne = str_replace("jep",$row['nogle-id'],$kolonne);
$kolonne = str_replace("nogle",$row['nogle'],$kolonne);


//Brugertype
if ($row["brugertype"] == "2") {
	$standard = '<select class="selecttab" id="brugertype1111" onchange="changebrugertype(1234)"><option value="3" >Medlem</option><option value="2" selected="selected">Træner</option></select>';
} else {
	$standard = '<select class="selecttab" id="brugertype1111" onchange="changebrugertype(1234)"><option value="3" selected="selected">Medlem</option><option value="2">Træner</option></select>';
}

if($_SESSION["brugertype"]== "2") {
	$standard = str_replace("<select","<select disabled",$standard);
}

if(($_SESSION["brugertype"]== "1") and (!($row["ejer"] == ""))) {
	$standard = str_replace("<select","<select disabled",$standard);
}

$standard = str_replace("1234",$row["nogle-id"],$standard);
$standard = str_replace("brugertype1111", $row["nogle-id"], $standard);
$kolonne = str_replace("brugertype",$standard,$kolonne);

//Ejer
if ($row["ejer"] == "") {
	$kolonne = str_replace("ejer","- -",$kolonne);
} else {
	$kolonne = str_replace("ejer",$row["ejer"],$kolonne);
}

//Værktøj
if ($row["ejer"] =="") {
	$basics = '<button class="vorktoj" onclick="kopi(1234)"><i class="fa fa-files-o"></i> Copy</button><button id="delete" class="ketchusp tooltip" title="Kommer snart! :)"><i class="fa fa-envelope-o"></i> Send mail</button><button class="vorktoj" onclick="slet(1111)"><i class="fa fa-times"></i> Delete</button>';
	$basics = str_replace("1234", $row["nogle-id"], $basics);
	$basics = str_replace("1111", $row["nogle-id"], $basics);
	$kolonne = str_replace("asdasdasdasd",$basics,$kolonne);
} else {
	$kolonne = str_replace("asdasdasdasd","",$kolonne);
}





//Tilføj til the basic
$basictabel = $basictabel . "\r\n" . $kolonne;

}


//ECHO DET HELE UD!
$basictabel = $basictabel . "\r\n" . "</table>";
echo $basictabel;

//JAVASCRIPT til brugertype + Copy + Delelte
$jsscript = <<<tekst
			<script>
				function changebrugertype(nogleid) {
					var mySelect = document.getElementById(nogleid);
					window.location.replace('/joha2514/changebrugertype.php?brugertype=' + mySelect.options[mySelect.selectedIndex].value + '&nogleid=' + nogleid);
				}
				function kopi(nogleidd) {
					var alt = nogleidd + "yea";
					var alt2 = document.getElementById(alt).innerText;
					window.prompt("Kopiér til udklipsholderen: Ctrl+C, Enter", alt2);
				}
				function slet(nogleid) {
					window.location.replace('/joha2514/sletkolonne.php?nogleid=' + nogleid);
				}
			</script>
tekst;

echo $jsscript;


//ECHO Tiljø en nøgle
$html = <<<tekst
	<input type="checkbox" id="regibruger" onchange="checkboxregi()">Vis registrerede brugere<br>
		<a id="tilfoj"><i id = "icon" class="fa fa-plus"></i> Tilføj en ny nøgle - brugertype: </a>
        <select id="bruger">
            <option value="3">Medlem</option>
            <option value="2">Træner</option>
        </select>
        <button id="udfor" onclick="add()">Udfør</button>

        <script>

        function add() {
        	var mySelect = document.getElementById("bruger");
        	window.location.replace('/joha2514/addnewkey.php?brugertype=' + mySelect.options[mySelect.selectedIndex].value);
        }
        function checkboxregi() {
        	var x = document.getElementById("regibruger").checked;
        	window.location.replace('/joha2514/checkboxregi.php?checkboxvalue=' + x);
        }
    	</script>
tekst;

if ($_SESSION["brugertype"] == "2") {
	$html = str_replace('<option value="2">Træner</option>', '', $html);
}

echo $html;

//CHECKBOX CHECKED ELLER UNCHECKED
if ($_SESSION["visregi"] =="") {
	echo '<script>var x = document.getElementById("regibruger"); x.checked = false;</script>';
} else {
	echo '<script>var x = document.getElementById("regibruger"); x.checked = true;</script>';
}
}







If ($_SESSION["brugertype"]== "1") {

	$log = <<<tekst
        <script>
        document.getElementById("logtekst").innerHTML = "Log af";
        function loggg() {
        	window.location.replace('/joha2514/logaf.php');
        }
    	</script>
tekst;
echo $log;
echo "<script type='text/javascript'>alert('Hej Admin');</script>";

} elseif ($_SESSION["brugertype"]== "2") {

	$log = <<<tekst
        <script>
        document.getElementById("logtekst").innerHTML = "Log af";
        function loggg() {
        	window.location.replace('/joha2514/logaf.php');
        }
       	</script>
tekst;
echo $log;
echo "<script type='text/javascript'>alert('Hej Træner');</script>";

} elseif ($_SESSION["brugertype"]== "3") {

	$log = <<<tekst
        <script>
        document.getElementById("logtekst").innerHTML = "Log af";
        function loggg() {
        	window.location.replace('/joha2514/logaf.php');
        }
    	</script>
tekst;
echo $log;
echo "<script type='text/javascript'>alert('Hej Medlem');</script>";

} else {
	$log = <<<tekst
        <script>
        function loggg() {
        	window.location.replace('/joha2514/login.php');
        }
    	</script>
tekst;
echo $log;

$info = <<<tekst
        <div style="height:500px;">

		</div>
tekst;
echo $info;
echo "<script type='text/javascript'>alert('Hej Gæst');</script>";
}
?>
