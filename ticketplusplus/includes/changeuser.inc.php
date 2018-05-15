<?php
include_once 'db_connect.php';
include_once 'psl-config.php';

if (isset($_POST['userid'], $_POST['username'], $_POST['uservorname'], $_POST['usernachname'], $_POST['dept_menu'], $_POST['role_menu'], $_POST['telnr'], $_POST['email'])) {
    $userid = $_POST['userid'];
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $vorname = filter_input(INPUT_POST, 'uservorname', FILTER_SANITIZE_STRING);
    $nachname = filter_input(INPUT_POST, 'usernachname', FILTER_SANITIZE_STRING);
		
    $deptname = $_POST['dept_menu'];
	$stmt = "SELECT dept_id FROM ticketplusplus.department WHERE beschreibung = '$deptname'";
	$result = mysqli_query($mysqli,$stmt) or die($mysqli);
    while(list($temp) = mysqli_fetch_row($result)) {
		$deptID = $temp;
    }
	$result = mysqli_query($mysqli,$stmt) or die($mysqli);
	while(list($temp) = mysqli_fetch_row($result)) {
	    $roleID = $temp;
	}
    
    $telnummer = filter_input(INPUT_POST, 'telnr', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message="<div class='alert alert-danger'>Die einegebene Email ist nicht gültig</div>";
        header("Location: ./viewuser.php?userid=$userid");
    }

    if (empty($message)) {

        $sql = "UPDATE ticketplusplus.users SET username = '$username', email = '$email', vorname = '$vorname', nachname = '$nachname', telefonnummer = '$telnummer', dept_id = '$deptID', role_id = '$roleID' WHERE id = $userid";
        
        if ($mysqli->query($sql) === TRUE) {
            $message='<div class="alert alert-success">Der User wurde erfolgreich geändert!</div>';
            header("Location: ./viewuser.php?userid='$userid'");
        }
        else {
            $message="<div class='alert alert-danger'>Leider ist beim Ändern des Users ein Fehler aufgetreten. Fehlercode: $sql</div>";
            header("Location: ./viewuser.php?userid=$userid");
        }
    }
}