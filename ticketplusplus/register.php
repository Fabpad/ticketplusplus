<?php $title = 'Register - Ticketplusplus'; ?>
<?php $currentPage = 'Register'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include_once 'includes/register.inc.php'; ?>
<?php include('head.php'); ?>

<body>
<?php if (login_check($mysqli) == true) : ?>
<?php if ($roleperm == 3): ?>
<?php include('nav-bar.php'); ?>
	<?php
        if (!empty($message)) {
            echo $message;
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
						<li class="list-group-item">Benutzernamen müssen mindestens 4 und maximal 30 Zeichen enthalten.</li>
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
<?php else : ?>
	<p>
		<span class="error">Sie haben nicht die Berechtigung diese Seite aufzurufen. <a href="home.php">Zurück zur Startseite</a>.
	</p>
<?php endif; ?>
<?php else : ?>
	<p>
		<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
	</p>
<?php endif; ?>
<?php include('footer.php'); ?>