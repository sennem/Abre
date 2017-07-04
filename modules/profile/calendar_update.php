<?php


	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');

	$calendardaystosave=$_POST["calendardaystosave"];
	$year = $_POST["year"];
	$json = $_POST["jsonDates"];
	$email = $_POST["email"];

	//if the json value passed from javascript == null.
	//we need to insert the days to save in to a new blannk array
	if($json == null || !isset($json)){
			$replacement = array($year => $calendardaystosave);
			$ret = array_replace(array(), $replacement);
			$ret = json_encode($ret);
	//there is already existing json, so we just need to replace the year entry
	//with the new dates to save
	}else{
		$replacement = array($year => $calendardaystosave);
		$ret = array_replace($json, $replacement);
		$ret = json_encode($ret);
	}

	//make a request to save the values in the databse for the year.
	include "../../core/abre_dbconnect.php";
	$stmt = $db->stmt_init();
	$sql = "UPDATE profiles set work_calendar='$ret' where email='$email'";
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->store_result();
	$num_rows = $stmt->num_rows;
	$stmt->close();
	$db->close();

?>
