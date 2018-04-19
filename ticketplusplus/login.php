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
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" href="styles/main.css" />
	<script type="text/JavaScript" src="js/sha512.js"></script> 
	<script type="text/JavaScript" src="js/forms.js"></script> 
</head>
<body style="background-color:#ffb516">
	<?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
    ?> 
	<div class="input-group-addon">
		<img class="center-fit" src="assets/TPPlogo2.png" alt="Logo" style="width:auto;">
	</div>	
	<form action="includes/process_login.php" method="post" name="login_form" class="login_form col-sm-4 col-md-4 col-lg-4"> 
		<input type="text" class="form-control" placeholder="Email" size="40" maxlength="250" name="email" id="email" /></br>
		<input type="password" class="form-control" placeholder="Passwort" size="40" maxlength="250" name="password" id="password"/></br>
		<input type="button" class="btn btn-secondary" value="Login" onclick="formhash(this.form, this.form.password);" id="login" />
		<script type="text/JavaScript" src="js/login_on_enter.js"></script> 
		<p>If you are done, please <a href="includes/logout.php">log out</a>.</p>
		<p>You are currently logged <?php echo $logged ?>.</p>				   
	</form>
    </body>
</html>
