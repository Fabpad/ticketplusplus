<?php
require_once "includes/Role.php";
require_once "includes/PrivilegedUser.php";

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
	<link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
	<link rel="stylesheet" href="styles/table.css" />
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
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-secondary my-2 my-sm-0" type="submit">Suchen</button>
			</form>
			<div class="dropdown ml-5">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="background-color:#ffb516">
					<span class="glyphicon glyphicon-user" aria-hidden="true"> </span>
					<?php echo htmlentities($_SESSION['username']); ?>
					<span class="caret"> </span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li><span class="glyphicon glyphicon-cog" aria-hidden="true"></span><a href="#">  Konto</a></li>
					<li role="separator" class="dropdown-divider"></li>
					<li><span class="glyphicon glyphicon-off" aria-hidden="true"></span><a href="includes/logout.php">  Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<div class="ml-5 mt-5 input-group">
		<label for="username">Benutzername</label>
		<div>
			<input id="username" type="text" class="form-control ml-3">
		</div>
	</div>
	<div class="ml-5 input-group">
		<label for="vorname">Vorname</label>
		<div>
			<input id="vorname" type="text" class="form-control ml-3">
		</div>
	</div>
	<div class="ml-5 input-group">
		<label for="nachname">Nachname</label>
		<div>
			<input id="nachname" type="text" class="form-control ml-3">
		</div>
	</div>
	<div class="ml-5 input-group">
		<label for="abteilung">Abteilung</label>
		<div>
			<input id="abteilung" type="text" class="form-control ml-3">
		</div>
	</div>
	<div class="ml-5 input-group">
		<label for="role">Rolle</label>
		<div>
			<input id="role" type="text" class="form-control ml-3">
		</div>
	</div>
	<label for="kontanktdaten" class="h3 ml-5">Kontakt</label>
	<div id="kontanktdaten">
		<div class="ml-5 input-group">
			<label for="telnummer">Telefonnummer</label>
			<div>
				<input id="telnummer" type="text" class="form-control ml-3">
			</div>
		</div>
		<div class="ml-5 input-group">
			<label for="email">E-Mail</label>
			<div>
				<input id="email" type="text" class="form-control ml-3">
			</div>
		</div>
	</div>
	<div>
		<button class="btn btn-default ml-5" style="background-color:#ffb516">
			<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
			Passwort ändern
		</button>
	</div>
	 <?php else : ?>
            <p>
                <span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
            </p>
        <?php endif; ?>
</body>
</html>