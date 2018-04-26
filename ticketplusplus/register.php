<?php
include_once 'includes/db_connect.php';
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Registration Form</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
		<script src="js/jQuery-v3.3.1.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="styles/bootstrap/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
    </head>
    <body>
	<?php if (login_check($mysqli) == true) : ?>
	
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<h1>Nutzer anlegen</h1>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4">
					<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form">
			
						<input type="text" class="form-control" name="username" id="username" placeholder="Nutzername" /><br>

						<input type="text" class="form-control" name="vorname" id="vorname" placeholder="Vorname" /><br>
						
						<input type="text" class="form-control" name="nachname" id="nachname" placeholder="Nachname" /><br>
						
						<input type="text" class="form-control" name="email" id="email" placeholder="Email" /><br>
						
						<input type="text" class="form-control" name="telnummer" id="telnummer" placeholder="Telefonnummer" /><br>
						
						<input type="password" class="form-control" name="password" id="password" placeholder="Passwort" /><br>
						
						<input type="password" class="form-control" name="confirmpwd" id="confirmpwd" placeholder="Passwort bestätigen" /><br>
						
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="role">Rolle</label>
							</div>
							<select class="custom-select" id="role" name="role">
								<option selected>Berechtigung des Nutzers...</option>
								<?php
									$stmt = "SELECT DISTINCT role_name FROM ticketplusplus.roles";
									$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
									while(list($role) = mysqli_fetch_row($result)){
										echo '<option value="'.$role.'">'.$role.'</option>';
									}
								?>
							</select>
						</div><br>
		
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="dept">Abteilung</label>
							</div>
							<select class="custom-select" id="dept" name="dept">
								<option selected>Abteilung des Nutzers...</option>
								<?php
									$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.department";
									$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
									while(list($dept) = mysqli_fetch_row($result)){
										echo '<option value="'.$dept.'">'.$dept.'</option>';
									}
								?>
							</select>
						</div><br>
						
						<input type="button" class="btn btn-secondary" value="Register" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd, this.form.role.value);" /> 
					
					</form>
				</div>
				
			<div class="col-sm-12 col-md-8 col-lg-8">
					<ul class="list-group">
						<li class="list-group-item">Benutzernamen dürfen nur Ziffern, Groß- und Kleinbuchstaben und Unterstriche enthalten.</li>
						<li class="list-group-item">E-Mail-Adressen müssen ein gültiges Format haben.</li>
						<li class="list-group-item">Passwörter müssen mindestens sechs Zeichen lang sein.</li>
						<li class="list-group-item">Passwörter müssen enthalten
							<ul>
								<li >mindestens einen Großbuchstaben (A..Z)</li>
								<li >mindestens einen Kleinbuchstaben (a..z)</li>
								<li >mindestens eine Ziffer (0..9)</li>
							</ul>
						</li>
						<li class="list-group-item">Das Passwort und die Bestätigung müssen exakt übereinstimmen.</li>
					</ul>
				</div>
			</div>
		</div>
		<footer class="page-footer pt-4 mt-4">
			<div class="container-fluid text-center text-md-left">
				<div class="row">
					<div class="col-md-12">
						<p>Zurück zur <a href="login.php">Anmeldeseite</a>.</p>
					</div>
				</div>
			</div>
		</footer>
		<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
		<?php endif; ?>
    </body>
</html>