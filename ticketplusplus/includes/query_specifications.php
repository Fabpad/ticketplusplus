<?php
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
 
	sec_session_start();
	
	$category = $_POST['kategorie'];
	$category = mysql_real_escape_string($category);
	
	$stmt = "SELECT category_id FROM ticketplusplus.category WHERE beschreibung = "'$category'"";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	$id = $result;
	
	$stmt = "SELECT DISTINCT beschreibung FROM ticketplusplus.specification WHERE category_id = "'$id'"";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($category) = mysqli_fetch_row($result)){
		$selectBox .= '<option value="'.$category.'">'.$category.'</option>';
		echo $selectBox;
	}
?>
