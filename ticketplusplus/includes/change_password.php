<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start(); // Unsere selbstgemachte sichere Funktion um eine PHP-Sitzung zu starten.
 
if (isset($_POST['op'], $_POST['np'], $_POST['npc'])) {
    $old_pw = $_POST['op']; // Das gehashte Passwort.
	$new_pw = $_POST['np'];
	$new_pw_conf = $_POST['npc'];
	$username = htmlentities($_SESSION['username']);
	return 'fick dich';
	if($stmt = $mysqli->prepare("SELECasdT id, username, password, salt FROM users WHERE username = ?")){
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		
		$stmt->bind_result($user_id, $username, $db_password, $salt);
		$stmt->fetch();
		
		$old_pw = hash('sha512', $old_pw . $salt);
		if($stmt->num_rows == 1) {
			if($db_password == $old_pw) {
				// Erstelle ein zufälliges Salt
				$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
 
				if($new_pw == $new_pw_conf){
					$new_pw = hash('sha512', $new_pw . $random_salt);
					if($update_stmt = $mysqli->prepare("UPDATE ticketplusplus.users SET password = ?, salt = ? WHERE id = ?")) {
						$update_stmt -> bind_param('sss', $new_pw, $random_salt, $user_id);
						if(! $update_stmt->execute()) {
							header('Location: ../home.php');
						}
						else{
							header('Location: ../login.php?error=1');
						}
					}
				}
				else{
					header('Location: ../login.php?error=12');
				}
			}
			else {
				header('Location: ../login.php?error=2');
			}
		}
		else{
			header('Location: ../login.php?error=2');
			return false;
		}
	}
}
else {
    // Die korrekten POST-Variablen wurden nicht zu dieser Seite geschickt. 
    echo 'Invalid Request';
}
?>