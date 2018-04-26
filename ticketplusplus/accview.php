<?php $title = 'Accountview - Ticketplusplus'; ?>
<?php $currentPage = 'AccView'; ?>
<?php $metaTags = 'tag1 tag2'; ?>
<?php include('head.php'); ?>
<body>
		<?php if (login_check($mysqli) == true) : ?>
<?php include('nav-bar.php'); ?>
		
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
		<button id="btnpw" class="btn btn-default ml-5 mt-3" style="background-color:#ffb516" onclick="showChangePassword()">
			<span class="fas fa-cog" aria-hidden="true"></span>
			Passwort ändern
		</button>
			<form id="changePasswordForm" class="mt-3 ml-3" style="display:none">
				<div class="input-group ml-5 mt-2 ">
					<div class="input-group-prepend">
						<i class="input-group-text">Altes Password eingeben </i>
					</div>
					<input type="password" placeholder="" name="old_pw" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" required>
				</div>
				<div class="input-group ml-5 mt-2">
					<div class="input-group-prepend">
						<i class="input-group-text">Neues Passwort eingeben </i>
					</div>
					<input type="password" placeholder="" name="new_pw" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" required>
				</div>
				<div class="input-group ml-5 mt-2">
					<div class="input-group-prepend">
						<i class="input-group-text">Neues Passwort bestätigen </i>
					</div>
					<input type="password" placeholder="" name="conf_new_pw" class="form-control col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" required>
				</div>
				<button type="submit" class="btn btn-secondary ml-5 mt-2">Ändern</button>
			</form>
	</div>

<?php else : ?>
				<p>
					<span class="error">Sie sind nicht für diese Seite berechtigt.</span> bitte <a href="login.php">einloggen </a>.
				</p>
<?php endif; ?>
<?php include('footer.php'); ?>