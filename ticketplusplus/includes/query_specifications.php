<?php
	include_once 'db_connect.php';
	include_once 'functions.php';

	// sec_session_start();
	
	$selectedCategory = $_POST['kategorie'];
	
	$stmt = "SELECT category_id FROM ticketplusplus.category WHERE beschreibung = '$selectedCategory'";
	$result = mysqli_query($mysqli,$stmt) or die(mysqli_error($mysqli));
	while(list($temp) = mysqli_fetch_row($result)){
		$id = $temp;
	}

	$stmt2 = "SELECT DISTINCT beschreibung FROM ticketplusplus.specification WHERE category_id = '$id'";
	$result2 = mysqli_query($mysqli,$stmt2) or die(mysqli_error($mysqli));
	$selectBox = '<option value="">--- Bitte wählen --- </option>';
	while(list($category) = mysqli_fetch_row($result2)){
		$selectBox .= '<option value="'.$category.'">'.$category.'</option>';
	}
	
	echo $selectBox;
?>