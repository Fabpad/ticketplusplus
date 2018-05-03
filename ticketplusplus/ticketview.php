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
	<script type="text/JavaScript" src="js/fill_specifications.js"></script> 
	<link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/ticketview.css" />	
	<title> Platzhalter Ticketbetreff </title>
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
					<li><span class="fas fa-cog" aria-hidden="true"></span><a href="accview.php">  Konto</a></li>
					<li role="separator" class="dropdown-divider"></li>
					<li><span class="fas fa-power-off" aria-hidden="true"></span><a href="includes/logout.php">  Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	
	<div class="ml-5 mt-5 col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
		<label for="txt_betreff">Betreff</label>
		<input class="form-control" id="txt_betreff" type="text" placeholder="Benutzer entsperren, Speicherplatz erweitern, PC installieren ..." aria-label="Betreff" />
	</div>
	
	<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
		<label for="txt_beschreibung">Beschreibung</label>
		<textarea class="form-control" id="txt_beschreibung" placeholder="Beschreibung" aria-label="Beschreibung" rows="20" style="resize:none"></textarea>
	</div>
	
	<div class="ml-5 mt-3 col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 row">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="txt_user">Benutzer</label>
			<input class="form-control" type="text" id="txt_user">
		</div>
		<div class="ml-2 col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="status_menu">Status</label>
			<select class="custom-select d-block w-100" id="status_menu" required>
				<option value=""> --- Bitte wählen --- </option>
				<?php
					//Run Query
					$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.status";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($category) = mysqli_fetch_row($result)){
						echo '<option value="'.$category.'">'.$category.'</option>';
					}
				?>
			</select>
			<div class="invalid-feedback">
				Bitte einen Status auswählen.
			</div>
		</div>
		<div class="ml-2 col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
			<label for="priority_menu">Priorität</label>
			<select class="custom-select d-block w-100" id="priority_menu" required>
				<option value=""> --- Bitte wählen --- </option>
				<?php
					//Run Query
					$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.priority";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($category) = mysqli_fetch_row($result)){
						echo '<option value="'.$category.'">'.$category.'</option>';
					}
				?>
			</select>
			<div class="invalid-feedback">
				Bitte eine Priorität auswählen.
			</div>
		</div>
	</div>
	
	<div class="ml-5 mt-3 col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 row">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="category_menu">Kategorie</label>
			<select class="custom-select d-block w-100" id="category_menu" required>
				<option value=""> --- Bitte wählen --- </option>
				<?php
					//Run Query
					$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.category";
					$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
					while(list($category) = mysqli_fetch_row($result)){
						echo '<option value="'.$category.'">'.$category.'</option>';
					}
				?>
			</select>
			<div class="invalid-feedback">
				Bitte eine Kategorie auswählen.
			</div>
		</div>
		<div class="ml-2 col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
			<label for="specification_menu">Unterkategorie</label>
			<select class="custom-select d-block w-100" id="specification_menu" required>
				<option value=""> --- Eine Kategorie wählen --- </option>
			</select>
			<div class="invalid-feedback">
				Bitte eine Unterkategorie auswählen.
			</div>
		</div>
	</div>
	
	<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
		<label for="txt_loesung">Lösung</label>
		<textarea class="form-control" id="txt_loesung" placeholder="Lösung" aria-label="Lösung" rows="20" style="resize:none"></textarea>
	</div>
	
	<div class="ml-5 mt-3 mr-5 col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
		<label for="txt_notizen">Notizen</label>
		<textarea class="form-control" id="txt_notizen" placeholder="Notizen" aria-label="Notizen" rows="10" style="resize:none"></textarea>
	</div>
	<input type="submit" class="ml-5 mt-3 btn btn-secondary" id="submit_ticket" value="Speichern">
		
	 <?php else : ?>
            <p>
                <span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
            </p>
        <?php endif; ?>
</body>
</html>