<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['vorname'], $_POST['nachname'],$_POST['telnummer'], $_POST['email'], $_POST['p'], $_POST['role'], $_POST['dept'])) {
    // Bereinige und überprüfe die Daten
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // keine gültige E-Mail
        $message="<div class='alert alert-danger'>Die einegebene Email ist nicht gültig</div>";
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // Das gehashte Passwort sollte 128 Zeichen lang sein.
        // Wenn nicht, dann ist etwas sehr seltsames passiert
        $message="<div class='alert alert-danger'>Ungültige Passwort Konfiguration</div>";
    }
 
	$role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
	$dept = filter_input(INPUT_POST, 'dept', FILTER_SANITIZE_STRING);
	$vorname = filter_input(INPUT_POST, 'vorname', FILTER_SANITIZE_STRING);
	$nachname = filter_input(INPUT_POST, 'nachname', FILTER_SANITIZE_STRING);
	$telnummer = filter_input(INPUT_POST, 'telnummer', FILTER_SANITIZE_STRING);
	
    // Benutzername und Passwort wurde auf der Benutzer-Seite schon überprüft.
    // Das sollte genügen, denn niemand hat einen Vorteil, wenn diese Regeln   
    // verletzt werden.
 
    $prep_stmt = "SELECT id FROM users WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // Ein Benutzer mit dieser E-Mail-Adresse existiert schon
            $message="<div class='alert alert-danger'>Ein Nutzer mit dieser Email Adresse existiert bereits.</div>";
        }
    } 
    else {
        $message="<div class='alert alert-danger'>Datenbank Fehler</div>";
    }

    $prep_stmt = "SELECT id FROM users WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // Ein Benutzer mit diesem Username existiert schon
            $message="<div class='alert alert-danger'>Ein Nutzer mit diesem Namen existiert bereits.</div>";
        }
    } 
    else {
        $message="<div class='alert alert-danger'>Datenbank Fehler</div>";
    }
 
    if (empty($message)) {
        // Erstelle ein zufälliges Salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
 
        // Erstelle saltet Passwort 
        $password = hash('sha512', $password . $random_salt);
 
		// ID der ausgewählte Rollen abfragen
		$stmt = "SELECT role_id FROM ticketplusplus.roles WHERE role_name = '$role'";
		$result = mysqli_query($mysqli,$stmt) or die($mysqli);
		
		while(list($temp) = mysqli_fetch_row($result)) {
			$roleID = $temp;
		}
		
		// ID der ausgewählten Abteilung abfragen
		$stmt = "SELECT dept_id FROM ticketplusplus.department WHERE beschreibung = '$dept'";
		$result = mysqli_query($mysqli,$stmt) or die($mysqli);
		
		while(list($temp) = mysqli_fetch_row($result)) {
			$deptID = $temp;
		}
 
        // Trage den neuen Benutzer in die Datenbank ein 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO users (username, email, password, salt, vorname, nachname, telefonnummer, dept_id, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('sssssssii', $username, $email, $password, $random_salt, $vorname, $nachname, $telnummer, $deptID, $roleID);
            // Führe die vorbereitete Anfrage aus.
            if (! $insert_stmt->execute()) {
                $message="<div class='alert alert-danger'>Leider ist beim Anlegen des Users ein Fehler aufgetreten. Fehlercode: $stmt</div>";
            }
			else{
                $message='<div class="alert alert-success">Der User wurde erfolgreich angelegt!</div>';
			}
		}
    }
}