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
	
	//Check Authentication
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php');  
	require_once(dirname(__FILE__) . '/../../core/portal_functions.php');
	
	//Add the Book
	$bookcode=$_POST["bookcode"];
	$bookcode=preg_replace("/[^0-9]/","", $bookcode);

	include "../../core/portal_dbconnect.php";
	$sql = "SELECT *  FROM books where code='$bookcode'";
	$result = $db->query($sql);
	$numrows = $result->num_rows;
	$success=0;
	while($row = $result->fetch_assoc())
	{
		
		$Book_ID=htmlspecialchars($row["ID"], ENT_QUOTES);
		$Code_Limit=htmlspecialchars($row["Code_Limit"], ENT_QUOTES);
		$userid=finduseridcore($_SESSION['useremail']);
		
		//Check to see if book has already been added
		$sqlcheck = "SELECT *  FROM books_libraries where Book_ID='$Book_ID' and User_ID='$userid'";
		$resultcheck = $db->query($sqlcheck);
		$numrows = $resultcheck->num_rows;
		
		//Check to see if the coupon limit has been reached
		$sqlcheckcoupon = "SELECT *  FROM books_libraries where Book_ID='$Book_ID'";
		$resultcoupon = $db->query($sqlcheckcoupon);
		$numrowscoupon = $resultcoupon->num_rows;
		if($Code_Limit>$numrowscoupon or $Code_Limit==NULL)
		{	
			//Add book to users library
			if($numrows==0)
			{
				$stmt = $db->stmt_init();
				$sql = "INSERT INTO books_libraries (User_ID, Book_ID) VALUES ('$userid', '$Book_ID');";
				$stmt->prepare($sql);
				$stmt->execute();
				$stmt->close();
				$db->close();
				$success=1;
				echo "The book has been added to your library.";
			}
			else
			{
				$success=1;
				echo "The book is in your library.";
			}
		}
		else
		{
			$success=1;
			echo "No licenses are available.";
		}
		
	}
	
	if($success==0)
	{
		echo "Invalid Book Coupon";
	}
	
?>