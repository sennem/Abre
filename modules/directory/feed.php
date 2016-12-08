<?php
	
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	
	$returnarray = array();

	$building=htmlspecialchars($_GET["building"]);
	$building = preg_replace("/[^ \w]+/", "", $building);
	if($building=="All")
	{
		$sql = "SELECT firstname, lastname, email, title, picture FROM directory where archived=0 order by lastname";
	}
	else
	{
		$school=encrypt("$building", "");
		$sql = "SELECT firstname, lastname, email, title, picture FROM directory where location='$school' and archived=0 order by lastname";
	}
	$result = $db->query($sql);
	$numberofrows = $result->num_rows;
	while($row = $result->fetch_assoc())
	{
		$firstname=$row["firstname"];
		$firstname=stripslashes(decrypt($firstname, ""));
		$lastname=$row["lastname"];
		$lastname=stripslashes(decrypt($lastname, ""));
		$email=$row["email"];
		$email=stripslashes(decrypt($email, ""));
		$title=$row["title"];
		$title=stripslashes(decrypt($title, ""));
		$picture=$row["picture"];
		if($picture==""){ 
			$picture='user.png';
		}
		$returnarray[] = array('firstname' => $firstname,'lastname' => $lastname,'email' => $email,'title' => $title,'picture' => $picture);
	}
	
	if (!empty($returnarray))
	{
		print_r(json_encode($returnarray));
	}

?>