<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />	
	<title>Opret bruger</title>
	<link rel="stylesheet" type="text/css" href="create_user.css" />
</head>
<body>
	<h1>Opret bruger</h1>

	<form id="loginform">
		<table id="table1">

			<p>
				<label>Fornavn</label>
				<input type="text" name="fornavn" id="fornavn" size="20" required/>
			</p>

			<p>
				<label>Efternavn</label>
				<input type="text" name="efternavn" id="efternavn" size="20" required/>
			</p>

			<p>
				<label>Telefonnummer</label>
				<input type="text" name="telefon" id="telefon" size="20" required/>
			</p>

			<p>
				<label>E-mail</label>
				<input type="email" name="email" id="email" size="20" required/>
			</p>

			<p>
				<label>Kodeord</label>
				<input type="password" name="kodeord_1" id="kodeord_1" size="20" required/>
			</p>
			<p>
				<label>Gentag kodeord</label>
				<input type="password" name="kodeord2" id="kodeord2" size="20" required/>
			</p>

			<p>
				<label>Medlemsnøgle</label>
				<input type="text" name="key" id="key" size="20" required/>
			</p>

			<p class="submit">
				<input type="submit" name="submit" id="submit"  value="Opret bruger" />
			</p>


		</table>

	</form>



</body>
</html>