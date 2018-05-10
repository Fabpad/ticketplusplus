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
		<script src="js/forms.js"></script>
		<script src="js/sha512.js"></script>
		<link rel="icon" type="image/png" href="assets/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/main.css" />
		<title><?php echo($title); ?></title>
	</head>

	<?php
			$user = htmlentities($_SESSION['username']);
			$stmt = "SELECT role_id FROM ticketplusplus.users WHERE username = '$user'";
			$result= mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
			while(list($temprole) = mysqli_fetch_row($result)){
				$roleperm = intval($temprole);
			}
		?>