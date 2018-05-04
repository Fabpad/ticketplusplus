<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Ticket++</title>
		<script type="text/JavaScript" src="js/sha512.js"></script> 
		<script type="text/JavaScript" src="js/forms.js"></script>
		<link rel="icon" type="image/png" href="assets/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/loginstyle.css" />
	</head>
	<body>
		<?php
			if (isset($_GET['error'])) {
				echo '<p class="error">Error Logging In!</p>';
			}
		?>
		
		<div class="input-group-addon">
			<img class="center-fit" src="assets/TPPlogo2.png" alt="Logo" style="width:auto;">
		</div>
		
		<form action="includes/process_login.php" method="post" name="login_form" class="login_form">
		
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<i class="input-group-text fas fa-user"></i>
				</div>
				<input type="text" class="form-control" placeholder="Email" size="40" maxlength="250" name="email" id="email" required />
			</div>
			
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text fas fa-lock" aria-hidden="true"> </span>
				</div>
				<input type="password" class="form-control" placeholder="Passwort" size="40" maxlength="250" name="password" id="password" required />
			</div>
			
			<input type="button" class="btn btn-secondary" value="Login" onclick="formhash(this.form, this.form.password);" id="login" />
			
			<script type="text/JavaScript" src="js/login_on_enter.js"></script> 

			If you are done, please <a href="includes/logout.php">log out</a>.
			You are currently logged <?php echo $logged ?>.
		</form>	
	</body>
</html>
