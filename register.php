<?php
	session_start();
	$navn = $_POST['navn'];
	$adresse = $_POST['adresse'];
	$mobil = $_POST['mobil'];
	$email = $_POST['email'];

	$mednogle = $_POST['med-nogle'];

    $mysql_hostname = 'localhost';
    $mysql_username = 'HIDDEN';
    $mysql_password = 'HIDDEN';
    $mysql_dbname = 'joha2514';

 	$done = 'no';

    if (strlen($_POST['password']) <= 40 && strlen($_POST['password']) >= 11) {
        $password = sha1($_POST['password']);
        try
        {
            $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dbh->prepare('UPDATE `nyebrugere` SET `adresse`=:adresse, `ejer`=:ejer,`Email`=:mail,`Adgangskode`=:kode,`Telefonnummer`=:nummer WHERE `nogle`=:nogle');

            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $stmt->bindParam(':ejer', $navn, PDO::PARAM_STR);
            $stmt->bindParam(':mail', $email, PDO::PARAM_STR);
            $stmt->bindParam(':kode', $password, PDO::PARAM_STR);
            $stmt->bindParam(':nummer', $mobil, PDO::PARAM_STR);
            $stmt->bindParam(':nogle', $mednogle, PDO::PARAM_STR);

            $stmt->execute();

            $con = mysqli_connect($mysql_hostname, $mysql_username, $mysql_password, $mysql_dbname);

            $result = mysqli_query($con, 'SELECT * from `joha2514`.`nyebrugere`');
            while ($row = mysqli_fetch_array($result)){
                if($row['Email']==$email){
                    If($row['Adgangskode']==$password) {
                        $_SESSION["blokeret"] ="";
                        $_SESSION["triedtimes"] = 0;
                        $_SESSION["brugertype"] = $row['brugertype'];
                        $done = "ja";
                        header("Location: http://webhotel.herningsholm.dk/joha2514");
                    }

                    }
                }

        }
        catch(Exception $e)
        {

        }
        if ($done == "no") {
            header("Location: http://webhotel.herningsholm.dk/joha2514/login.php");
        }
    }

?>
