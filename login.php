<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>
			Login | FC Midtjylland
		</title>
		<link rel="shortcut icon" href="icon.png">
		<link rel="stylesheet" type="text/css" href="login.css" />
		<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
		<link rel="stylesheet" type="text/css" href="css/tooltipster-light.css"/>
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	    <script type="text/javascript" src="js/jquery-1.7.0.min.js"></script>
	    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>
  		<script type="text/javascript" src="js/jquery-ui.js"></script>
  		<script type='text/javascript' src="js/jquery.bpopup.min.js"></script>

  		<script type='text/javascript'>//BPOPUP
  		$(document).ready(function(){
			  $('#opret').click(function(){
		        $('#popup').bPopup({
			    	easing: 'easeOutBack', //uses jQuery easing plugin
		            speed: 550,
		            transition: 'slideDown'
		        });
		    });
		});
		</script>
	</head>
	<body>

		<a href="http://webhotel.herningsholm.dk/joha2514"><img src="icon.png" id="icon"></a>
		<a><h1>FC Midtjylland</h1></a>

		<div id="error">Du har indtastet en forkert email eller adgangskode (forsøg <a id="gange">1</a> af 5)</div>
		<form name="loginform" id="loginform"  method="post">
		<table>
	    <p>
		<label for="brugernavn">Email</label>
		<input type="email" name="email"  id="email" class="input" size="20" required>
		</p>

		<p>
		<label for="adgangskode">Adgangskode</label>
		<input type="password" name="adgangskode" id="adgangskode" class="input" required>
		</p>

		<p class="submit">
		<input type="submit" name="submit" id="submit"  value="Log Ind" />
		</p>

		<p id="pad">
		<a id="opret" href="#" class="ketchusp tooltip" title="En medlems-nøgle er påkrævet!">Opret en bruger »</a>
		</p>

	  	</table>
		</form>

		<div id="popup" style="display: none;">
    <span class="button b-close"></span>
    <h2 id="overskriftpopup">Registrering af bruger</h2>
    	<div class="alt">
    		<form id="validationForm" action="register.php" onsubmit="return vali2();" method="post">
    			<p>
				<label class="las">Fulde navne</label>
				<input type="text" name="navn"  id="navn" class="inputet" size="20" onchange="checknavn2()" required>
				</p>
				<p>
				<label class="las">Adresse</label>
				<input type="text" name="adresse"  id="adresse" class="inputet" size="20" onchange="checkadresse2()" required>
				</p>
				<p>
				<label class="las">Mobil</label>
				<input type="number" name="mobil"  id="mobil" class="inputet" size="20" onchange="checknumber2()" required>
				</p>
				<p>
				<label class="las">E-mail</label>
				<input type="email" name="email"  id="email2" class="inputet" size="20" onchange="checkmail2()" required>
				</p>
				<label class="las">Adgangskode</label>
				<input type="password" name="password"  id="adgangskode2" class="inputet" size="20" onchange="checkadg2()" required>
				</p>
				</p>
				<label class="las">Medlems-nøgle</label> <label id="huh" class="ketchusp tooltip" title="En medlems-nøgle er påkrævet for at oprette en bruger. Kontakt din træner for at få en medlems-nøgle."> ?</label>
				<input type="number" name="med-nogle"  id="med-nogle" class="inputet" size="20" onchange="checkkey2()"  required>
				</p>
				<p class="submit2">
				<input type="submit" name="submit2" id="submit2"  value="Registrér!" />
				</p>
			</form>
    </div>

		<script>
        $(document).ready(function() {
           $('.tooltip').tooltipster({
           	theme: 'tooltipster-light',
           	animation: 'fade',
           	delay: 100
           	});
        });
    	</script>

	</body>
</html>


<?php
	session_start();
	if ($_SESSION["triedtimes"] == "") {
		$_SESSION["triedtimes"] = 0;
	}

	If ($_SESSION["blokeret"] == "ja") {
		date_default_timezone_set("Europe/Copenhagen");


		If ((substr($_SESSION["unblocktime"],10,2)) > (date("i"))) {
			$tidleft = (substr($_SESSION["unblocktime"],12,2)) + (60 - (date("s")));
		} else {
			$tidleft = (substr($_SESSION["unblocktime"],12,2)) - (date("s"));
		}


		If (date("Ymdhis") >= $_SESSION["unblocktime"] ) {
			$_SESSION["blokeret"] ="";
			$_SESSION["triedtimes"] = 0;
		}

	}

	$submit = $_POST['submit'];
	/*** check om login button er trykket ***/
	if (isset($submit))
	{
		if ($_SESSION["blokeret"] == "") {
			if(isset($_POST['email'], $_POST['adgangskode']))
			{
				if (strlen($_POST['adgangskode']) <= 40 && strlen($_POST['adgangskode']) >= 11)
				{
					if (ctype_alnum($_POST['adgangskode']) != false)
					{
						tjekemailogpass();
					}
					else
					{
						wrongloginparameters();
					}
				}
				else
				{
					wrongloginparameters();
				}
			}
			else
			{
				wrongloginparameters();
			}
		}
		else
		{
			toomanyatempts();
		}
	}


	function tjekemailogpass() {
		//Når funktionen "tjekemailogpass" bliver kaldt så skal den gøre følgende:

    	$db_server = "localhost";
    	//Vi fortæller php at databaseserveren ligger på den samme server som denne her.

		$db_brugernavn = "HIDDEN";
		//Brugernavnet til databasen

		$db_password = "HIDDEN";
		//Password til databasen

		$db_dbnavn = "joha2514";
		//Databasen hedder joha2514

		$con = mysqli_connect($db_server, $db_brugernavn, $db_password, $db_dbnavn);
		//Vi tilslutter databasen

		$email = $_POST['email'];
		//Vi henter emailen fra formen(POST).

		$pass = sha1($_POST['adgangskode']);
		//Vi henter adgangskoden fra formen(POST).

		$fundetmatchemail = 0;
		//Sætter en variable til 0

		$result = mysqli_query($con, 'SELECT * from `joha2514`.`nyebrugere`');
		//Vi sender en mysql forespørgelse til den tilsluttede database. Forspørgelsen: Vælg hver række i databasen joha2514 og i tabellen nyebrugere.

		while ($row = mysqli_fetch_array($result)){
		//Skriv hver enkelt række ud indtil der ikke er flere.

			if($row['Email']==$email){
			//Hvis der er en email der matcher den indtastede så skal den gå ind i IF.

				$fundetmatchemail = 1;
				//Variablen $fundetmatchemail skal være lig med 1.

				If($row['Adgangskode']==$pass) {
					//Hvis adgangskoden matcher den indstatede så skal den gå ind i IF.

					$_SESSION["blokeret"] ="";
					//Sessionen med variablen "blokeret" skal være lig med ingenting.

					$_SESSION["triedtimes"] = 0;
					//Sessionen med variablen "triedtimes" skal være lig med 0.

					$_SESSION["brugertype"] = $row['brugertype'];
					//Sessionen med variablen "brugertype" skal være lig værdien i brugertypen

					header("Location: http://webhotel.herningsholm.dk/joha2514");
					//Gå til forsiden.

					die();
					//PHP stopper.
				}
				else {
				//Hvis adgangskoden ikke passer med den indtastede så skal gøre følgende:

					wrongloginparameters();
					//Kalde funktionen wrongloginparameters().
				}

				}
			}
		if($fundetmatchemail == 0) {
			//Hvis variablen "$fundetmatchemail" er lig med 0 så skal den gøre følgende:

			wrongloginparameters();
			//Kalde funktionen wrongloginparameters().
		}
	}

function wrongloginparameters() {
	$_SESSION["triedtimes"] += 1;
	if ($_SESSION["triedtimes"] == 5) {
		$_SESSION["blokeret"] = "ja";
		date_default_timezone_set("Europe/Copenhagen");
		$_SESSION["unblocktime"] = date("Ymdhis") + 100;
		toomanyatempts();
echo <<<EOF
	<script>
	  $( "#loginform" ).effect( "shake", {times: 1, distance: 15}, 120 );
      $( "#loginform" ).effect( "shake", {times: 1, distance: 7}, 120 );
      $( "#loginform" ).effect( "shake", {times: 1, distance: 0}, 120 );
	</script>
EOF;
		}

		/*** ELSE ***/
		else {

$tekst = <<<EOF1
	<script>
	  document.getElementById("gange").innerHTML = "triedtimes";
	  document.getElementById("error").style.display = "inline";
	  document.getElementById("error").style.visibility = "visible";
	  document.getElementById("loginform").style.top = "315px";
	</script>
EOF1;
$tekst2= str_replace("triedtimes", $_SESSION["triedtimes"], $tekst);
echo $tekst2;

echo <<<EOF
	<script>
	  $( "#loginform" ).effect( "shake", {times: 1, distance: 15}, 120 );
      $( "#loginform" ).effect( "shake", {times: 1, distance: 7}, 120 );
      $( "#loginform" ).effect( "shake", {times: 1, distance: 0}, 120 );
	</script>
EOF;
		}




	}

function toomanyatempts() {
	echo <<<EOF2
		<script>
		  document.getElementById("error").innerHTML = "Din kvote på 5 login-forsøg er overskredet. Prøv igen om 1 min.";
		  document.getElementById("error").style.display = "inline";
		  document.getElementById("error").style.visibility = "visible";
		  document.getElementById("loginform").style.top = "315px";
		</script>
EOF2;
}



//VALIDATE INPUT FELTER
echo <<<EOF23
		<script>
		  function checknavn2() {
	       	var string = document.getElementById('navn').value;
			if (string.indexOf(" ") > -1) {
	    		$('#navn').css('border', 'solid 1px green');
			} else {
    			$('#navn').css('border', 'solid 1px #dd4b39');
			}
		}

		function checkadresse2() {
	    	var string = document.getElementById('adresse').value;
			if ((string.indexOf(" ") > -1) && ((string.indexOf("1") > -1) || (string.indexOf("2") > -1) || (string.indexOf("3") > -1) || (string.indexOf("4") > -1) || (string.indexOf("5") > -1) || (string.indexOf("6") > -1) || (string.indexOf("7") > -1) || (string.indexOf("8") > -1) || (string.indexOf("9") > -1))) {
	    		$('#adresse').css('border', 'solid 1px green');
			} else {
    			$('#adresse').css('border', 'solid 1px #dd4b39');
			}
		}

		function checknumber2() {
	    	var string = document.getElementById('mobil').value;
			if (string.length == "8") {
				$('#mobil').css('border', 'solid 1px green');
			} else {
    			$('#mobil').css('border', 'solid 1px #dd4b39');
			}
		}

		function checkmail2() {
	    	var string = document.getElementById('email2').value;
			if ((string.indexOf("@") > -1) && (string.indexOf(".") > -1)) {
	    		$('#email2').css('border', 'solid 1px green');
			} else {
    			$('#email2').css('border', 'solid 1px #dd4b39');
			}
		}

		function checkadg2() {
	    	var string = document.getElementById('adgangskode2').value;
			if ((string.length >= "11") && (string.length <= "40")) {
				$('#adgangskode2').css('border', 'solid 1px green');
			} else {
    			$('#adgangskode2').css('border', 'solid 1px #dd4b39');
			}
		}

		function checkkey2() {
	    	var key = document.getElementById('med-nogle').value;
            xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	                if (xmlhttp.responseText == "true") {
						$('#med-nogle').css('border', 'solid 1px green');
						} else {
			    			$('#med-nogle').css('border', 'solid 1px #dd4b39');
						}

	            }
	        }
	        xmlhttp.open("GET","validatekey.php?key="+key,true);
	        xmlhttp.send();
		}


		function vali2() {
		    var navnstring = document.getElementById('navn').value;
		    var adressestring = document.getElementById('adresse').value;
		    var mobilstring = document.getElementById('mobil').value;
		    var mailstring = document.getElementById('email2').value;
		    var adstring = document.getElementById('adgangskode2').value;

		    var key = document.getElementById('med-nogle').value;
            xmlhttp = new XMLHttpRequest();
	        xmlhttp.open("GET","validatekey.php?key="+key,false);
	        xmlhttp.send();

	        if ((navnstring.indexOf(" ") > -1) && (mobilstring.length == "8") && ((mailstring.indexOf("@") > -1) && (mailstring.indexOf(".") > -1)) && ((adstring.length >= "11") && (adstring.length <= "40")) && ((adressestring.indexOf(" ") > -1) && ((adressestring.indexOf("1") > -1) || (adressestring.indexOf("2") > -1) || (adressestring.indexOf("3") > -1) || (adressestring.indexOf("4") > -1) || (adressestring.indexOf("5") > -1) || (adressestring.indexOf("6") > -1) || (adressestring.indexOf("7") > -1) || (adressestring.indexOf("8") > -1) || (adressestring.indexOf("9") > -1))) && (xmlhttp.responseText == "true")) {
			} else {
				return false;
			}

		}
		</script>
EOF23;
?>
