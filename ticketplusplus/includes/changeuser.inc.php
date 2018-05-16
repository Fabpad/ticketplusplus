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

    $rolename = $_POST['role_menu'];
    $stmt = "SELECT role_id FROM ticketplusplus.roles WHERE role_name = '$rolename'";
	$result = mysqli_query($mysqli,$stmt) or die($mysqli);
	while(list($temp) = mysqli_fetch_row($result)) {
	    $roleID = $temp;
	}
    
    $telnummer = filter_input(INPUT_POST, 'telnr', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ./viewuser.php?userid=$userid&msgid=3");
    }

    else {

        $sql = "UPDATE ticketplusplus.users SET username = '$username', email = '$email', vorname = '$vorname', nachname = '$nachname', telefonnummer = '$telnummer', dept_id = '$deptID', role_id = '$roleID' WHERE id = $userid";
        
        if ($mysqli->query($sql) === TRUE) {
            header("Location: ./viewuser.php?userid=$userid&msgid=1");
        }
        else {
            header("Location: ./viewuser.php?userid=$userid&msgid=2");
        }
    }
}