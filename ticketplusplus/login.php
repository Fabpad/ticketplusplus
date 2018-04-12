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
	<title>Secure Login: Log In</title>
	<link rel="stylesheet" href="styles/main.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<script type="text/JavaScript" src="js/sha512.js"></script> 
	<script type="text/JavaScript" src="js/forms.js"></script> 
</head>
<body style="background-color:#ffb516">
	<?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
    ?> 
		<div class="imgbox">
			<img class="center-fit" src="assets/TPPlogo2.png" alt="Logo" style="width:auto;">
		</div>
		<form action="includes/process_login.php" method="post" name="login_form">                      
		Email: </br>
		<input type="text" size="40" maxlength="250" name="email" /></br>
		Password: </br>
		<input type="password" size="40" maxlength="250" name="password" id="password"/></br></br>
		<input type="button" class="btn btn-secondary" value="Login" onclick="formhash(this.form, this.form.password);" />
		<p>If you are done, please <a href="includes/logout.php">log out</a>.</p>
		<p>You are currently logged <?php echo $logged ?>.</p>				   
       </form>
    </body>
</html>