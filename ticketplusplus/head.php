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
		<script src="js/sha512.js"></script>
		<script src="js/tablesorter/jquery.tablesorter.min.js"></script>
		<script src="js/jquery.metadata.js"></script>
		<script src="js/Chart.bundle.min.js"></script>
		<script src="js/forms.js"></script>
		<link rel="icon" type="image/png" href="assets/favicon.png" sizes="32x32">
		<link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="styles/fontawesome/css/fontawesome-all.min.css">
		<link rel="stylesheet" href="styles/main.css" />
		<title><?php echo($title); ?></title>
		<script language="javascript">night_mode()</script>
	</head>

	<?php
			if(ISSET($_SESSION['username'])) :
				$user = htmlentities($_SESSION['username']);
				$stmt = "SELECT role_id FROM ticketplusplus.users WHERE username = '$user'";
				$result= mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
				while(list($temprole) = mysqli_fetch_row($result)){
					$roleperm = intval($temprole);
				}
			endif;
	?>