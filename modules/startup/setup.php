<?php
	
	/*
	* Copyright 2015 Hamilton City School District	
	* 		
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	* 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	* 
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */
	
	//Login Validation
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	
	//Insert/Update Profile
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	
	$profileupdatecount=0;
	$sql = "SELECT *  FROM profiles where email='".$_SESSION['useremail']."'";
	$result = $db->query($sql);

	while($row = $result->fetch_assoc())
	{
		$profileupdatecount=1;
		$stmt = $db->stmt_init();
		$sql2 = "UPDATE profiles set startup='0' where email='".$_SESSION['useremail']."'";
		$stmt->prepare($sql2);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();
		$db->close();
	}
	
	if ($profileupdatecount==0)
	{
		$stmt = $db->stmt_init();
		$sql = "Insert into profiles (id, email, startup) VALUES (NULL, '".$_SESSION['useremail']."', '0')";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$stmt->close();
		$db->close();	
	}


?>