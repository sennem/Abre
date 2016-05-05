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
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once('permissions.php');

	if($superadmin==1)
	{
		
		$id=mysqli_real_escape_string($db, $_GET["id"]);
		
		//Delete Picture
		include "../../core/abre_dbconnect.php";	
		$sql = "SELECT *  FROM directory where id=$id";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$oldpicture=htmlspecialchars($row["picture"], ENT_QUOTES);
			if($oldpicture!="")
			{
				$oldfile = dirname(__FILE__) . '/../../../../private/directory/images/employees/' . $oldpicture;
				unlink($oldfile);
			}
		}
		
		//Delete Discipline Files
		include "../../core/abre_dbconnect.php";	
		$sql = "SELECT *  FROM directory_discipline where UserID=$id";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$filename=htmlspecialchars($row["Filename"], ENT_QUOTES);
			if($filename!="")
			{
				$filename = dirname(__FILE__) . '/../../../../private/directory/discipline/' . $filename;
				unlink($filename);
			}
		}
		
		//Delete the Records
		include "../../core/abre_dbconnect.php";			
		$stmtrecord = $db->prepare("DELETE from directory_discipline where UserID = ?");
		$stmtrecord->bind_param("i",$id);	
		$stmtrecord->execute();
		$stmtrecord->close();
		$db->close();
		
		//Remove from Database
		include "../../core/abre_dbconnect.php";	
		$stmt = $db->stmt_init();
		$sql = "Delete from directory where id='$id' LIMIT 1";
		$stmt->prepare($sql);
		$stmt->execute();
		$stmt->store_result();
		$num_rows = $stmt->num_rows;
		$stmt->close();
		$db->close();
		
		echo "Employee Deleted!";
	}
		
?>