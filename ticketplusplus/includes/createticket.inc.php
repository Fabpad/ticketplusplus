<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
 
$error_msg = "";
 
if (isset($_POST['betreff'], $_POST['beschreibung'], $_POST['user'],$_POST['status_menu'], $_POST['priority_menu'], $_POST['category_menu'], $_POST['specification_menu'])) {
	$betreff = filter_input(INPUT_POST, 'betreff', FILTER_SANITIZE_STRING);
	$beschreibung = $_POST['beschreibung'];
	$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
	$status = $_POST['status_menu'];
	$priority = $_POST['priority_menu'];
	$category = $_POST['category_menu'];
	$specification = $_POST['specification_menu'];
	
	if (empty($error_msg)) {
		
		$stmt = "SELECT status_id FROM ticketplusplus.status WHERE beschreibung = '$status'";
		$result = mysqli_query($mysqli,$stmt) or die($mysqli);
		
		while(list($temp) = mysqli_fetch_row($result)) {
			$statusID = $temp;
		}
		
		$stmt = "SELECT priority_id FROM ticketplusplus.priority WHERE beschreibung = '$priority'";
		$result = mysqli_query($mysqli,$stmt) or die($mysqli);
		
		while(list($temp) = mysqli_fetch_row($result)) {
			$priorityID = $temp;
		}
		
		$stmt = "SELECT category_id FROM ticketplusplus.category WHERE beschreibung = '$category'";
		$result = mysqli_query($mysqli,$stmt) or die($mysqli);
		
		while(list($temp) = mysqli_fetch_row($result)) {
			$categoryID = $temp;
		}
		
		$stmt = "SELECT specification_id FROM ticketplusplus.specification WHERE beschreibung = '$specification'";
		$result = mysqli_query($mysqli,$stmt) or die($mysqli);
		
		while(list($temp) = mysqli_fetch_row($result)) {
			$specificationID = $temp;
		}
		
		if ($insert_stmt = $mysqli->prepare("INSERT INTO tickets (betreff, beschreibung, benutzer, status_id, priority_id, category_id, specification_id) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('sssiiii', $betreff, $beschreibung, $user, $statusID, $priorityID, $categoryID, $specificationID);
            // Führe die vorbereitete Anfrage aus.
            if (! $insert_stmt->execute()) {
                header("Location: ../error.php?err=Registration failure: INSERT $stmt");
            }
			else{
		header('Location: ./register_success.php');
			}
		}
	}
?>