<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<script src="js/jQuery-v3.3.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="styles/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="styles/accview.css">
	<link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

	<title> Platzhalter Konto </title>
</head>
<body>
	<?php if (login_check($mysqli) == true) : ?>
			<nav class="navbar navbar-expand-lg navbar-light">
			<a class="navbar-brand" href="#">Ticket ++</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Startseite <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="#">Neues Ticket</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Meine Tickets
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">alle Tickets</a>
							<a class="dropdown-item" href="#">offene Tickets</a>
							<a class="dropdown-item" href="#">geschlossene Tickets</a>
							<a class="dropdown-item" href="#">wartende Tickets</a>
						</div>
					</li>
				</ul>
				<form class="form-inline my-2 my-lg-0">
					<div class="input-group">
						<input class="form-control" type="search" placeholder="" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-secondary " type="submit">Suchen</button>
						</div>
					</div>
				</form>
				<div class="dropdown ml-5">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="background-color:#ffb516">
						<span class="fas fa-user" aria-hidden="true"> </span>
						<?php echo htmlentities($_SESSION['username']); ?>
						<span class="caret"> </span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li><span class="fas fa-cog" aria-hidden="true"></span><a href="#">  Konto</a></li>
						<li role="separator" class="dropdown-divider"></li>
						<li><span class="fas fa-power-off" aria-hidden="true"></span><a href="includes/logout.php">  Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
	<label for="user_info" class="h3 ml-5 mt-3">Informationen</label>
	<div id="user_info">
		<div class="ml-5 mt-2 input-group">
			<div class="input-group-prepend">
				<i class="input-group-text"> Benutzername </i>
			</div>
			<input id="username" type="text" value="<?php echo htmlentities($_SESSION['username']); ?>" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
		</div>
		<div class="ml-5 mt-2 input-group">
			<div class="input-group-prepend">
				<i class="input-group-text">Vorname</i>
			</div>
			<input id="vorname" type="text" value="<?php
					$loggedUser = htmlentities($_SESSION['username']);
					
					//Run Query
					$stmt = "SELECT DISTINCT vorname FROM ticketplusplus.users WHERE username =  '$loggedUser'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($vorname) = mysqli_fetch_row($result)){
						echo $vorname;
					}
				?>" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
		</div>
		<div class="ml-5 mt-2 input-group">
			<div class="input-group-prepend">
				<i class="input-group-text"> Nachname </i>
			</div>
			<input id="nachname" type="text" value="<?php
					$loggedUser = htmlentities($_SESSION['username']);
					
					//Run Query
					$stmt = "SELECT DISTINCT nachname FROM ticketplusplus.users WHERE username =  '$loggedUser'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($nachname) = mysqli_fetch_row($result)){
						echo $nachname;
					}
				?>" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
		</div>
		<div class="ml-5 mt-2 input-group">
			<div class="input-group-prepend">
				<i class="input-group-text"> Abteilung </i>
			</div>
			<input id="abteilung" type="text" value="<?php
					$loggedUser = htmlentities($_SESSION['username']);
					
					//Run Query
					$stmt = "SELECT DISTINCT dept_id FROM ticketplusplus.users WHERE username =  '$loggedUser'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$deptID = $temp;
					}
					
					//Run Query
					$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.department WHERE dept_id =  '$deptID'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($deptName) = mysqli_fetch_row($result)){
						echo $deptName;
					}
					
				?>" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
		</div>
		<div class="ml-5 mt-2 input-group">
			<div class="input-group-prepend">
				<i class="input-group-text"> Rolle </i>
			</div>
			<input id="rolle" type="text" value="<?php
					$loggedUser = htmlentities($_SESSION['username']);
					
					//Run Query
					$stmt = "SELECT DISTINCT role_id FROM ticketplusplus.users WHERE username =  '$loggedUser'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($temp) = mysqli_fetch_row($result)){
						$roleID = $temp;
					}
					
					//Run Query
					$stmt = "SELECT DISTINCT role_name FROM ticketplusplus.roles WHERE role_id =  '$roleID'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($roleName) = mysqli_fetch_row($result)){
						echo $roleName;
					}
					
				?>" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
		</div>
	</div>
	<label for="kontanktdaten" class="h3 ml-5 mt-3">Kontakt</label>
	<div id="kontanktdaten">
		<div class="ml-5 mt-2 input-group">
			<div class="input-group-prepend">
				<i class="input-group-text"> Telefonnummer </i>
			</div>
			<input id="telnummer" type="text" value="<?php
					$loggedUser = htmlentities($_SESSION['username']);
					
					//Run Query
					$stmt = "SELECT DISTINCT telefonnummer FROM ticketplusplus.users WHERE username =  '$loggedUser'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($telnummer) = mysqli_fetch_row($result)){
						echo $telnummer;
					}
				?>" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
		</div>
		<div class="ml-5 mt-2 input-group">
			<div class="input-group-prepend">
				<i class="input-group-text"> E-Mail </i>
			</div>
			<input id="email" type="text" value="<?php
					$loggedUser = htmlentities($_SESSION['username']);
					
					//Run Query
					$stmt = "SELECT DISTINCT email FROM ticketplusplus.users WHERE username =  '$loggedUser'";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($email) = mysqli_fetch_row($result)){
						echo $email;
					}
				?>" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
		</div>
	</div>
	<div>
		<button id="btnpw" class="btn btn-default dropdown-toggle ml-5 mt-3" style="background-color:#ffb516" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="fas fa-cog" aria-hidden="true"></span>
			Passwort ändern
		</button>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
			<form>
				<label for="old_pw"><b>Altes Password eingeben:</b></label>
				<input type="password" placeholder="" name="old_pw" class="form-control " required>
				<label for="new_pw"><b>Neues Passwort eingeben:</b></label>
				<input type="password" placeholder="" name="new_pw" class="form-control " required>
				<label for="conf_new_pw"><b>Neues Passwort bestätigen:</b></label>
				<input type="password" placeholder="" name="conf_new_pw" class="form-control" required>
				<button type="submit" class="btn btn-default" style="background-color:#ffb516">Ändern</button>
			</form>
		</ul>
	</div>

	<div id="pwform" class="modal">
		<form class="modal-content col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6" action="/change_password.php">
			<div class="container">
				<label for="old_pw"><b>Altes Password eingeben:</b></label>
				<input type="password" placeholder="" name="old_pw" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" required>
				<label for="new_pw"><b>Neues Passwort eingeben:</b></label>
				<input type="password" placeholder="" name="new_pw" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" required>
				<label for="conf_new_pw"><b>Neues Passwort bestätigen:</b></label>
				<input type="password" placeholder="" name="conf_new_pw" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" required>
				<button type="button" onclick="document.getElementById('pwform').style.display='none'" class="btn btn-default" style="background-color:#ffb516">Cancel</button>
				<button type="submit" class="btn btn-default" style="background-color:#ffb516">Sign Up</button>
				</div>
			</div>
		</form>
	</div>

	<script>
		// Get the modal
		var modal = document.getElementById('pwform');

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>
	 <?php else : ?>
            <p>
                <span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
            </p>
        <?php endif; ?>
</body>
</html>