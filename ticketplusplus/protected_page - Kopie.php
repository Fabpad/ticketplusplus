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
		<link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous"><link rel="stylesheet" href="styles/loginstyle.css" />
		<link rel="stylesheet" href="styles/table.css" />
		<title>Ticketplusplus</title>
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
		<table>
			<tr>
				<th>ID</th>
				<th>Betreff</th>
				<th>Status</th>
				<th>Mitarbeiter</th>
				<th>Priorit&auml;t</th>
				<th>Erstellt am</th>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
			</tr>
		</table>
			
			<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
			<?php endif; ?>
	</body
</html>
