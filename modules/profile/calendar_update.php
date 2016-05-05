<?php
	
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');

	$calendardaystosave=$_POST["calendardaystosave"];

	include "../../core/abre_dbconnect.php";
	$stmt = $db->stmt_init();
	$sql = "UPDATE profiles set work_calendar='$calendardaystosave' where email='".$_SESSION['useremail']."'";
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$num_rows = $stmt->num_rows;
	$stmt->close();
	$db->close();
		
	echo $calendardaystosave;
	
?>