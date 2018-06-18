<?php

	/*
	* Copyright (C) 2016-2018 Abre.io Inc.
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */

	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');

	//Add the book to user library
	$bookcode=$_POST["bookcode"];
	$bookcode=preg_replace("/[^0-9]/","", $bookcode);
	$sql = "SELECT ID, Code_Limit FROM books WHERE code='$bookcode'";
	$result = $db->query($sql);
	$numrows = $result->num_rows;
	while($row = $result->fetch_assoc())
	{

		$Book_ID=htmlspecialchars($row["ID"], ENT_QUOTES);
		$Code_Limit=htmlspecialchars($row["Code_Limit"], ENT_QUOTES);

		//Check to see if book has already been added
		if($_SESSION['usertype']!="parent")
		{
			$userid=finduseridcore($_SESSION['useremail']);
			$sqlcheck = "SELECT COUNT(*) FROM books_libraries WHERE Book_ID='$Book_ID' AND User_ID='$userid'";
			$resultcheck = $db->query($sqlcheck);
			$returnrow = $resultcheck->fetch_assoc();
			$numrows3 = $returnrow["COUNT(*)"];
		}
		else
		{
			$userid=finduseridparent($_SESSION['useremail']);
			$sqlcheck = "SELECT COUNT(*) FROM books_libraries WHERE Book_ID='$Book_ID' AND Parent_ID='$userid'";
			$resultcheck = $db->query($sqlcheck);
			$returnrow = $resultcheck->fetch_assoc();
			$numrows3 = $returnrow["COUNT(*)"];
		}

		//Check to see if the coupon limit has been reached
		$sqlcheckcoupon = "SELECT COUNT(*) FROM books_libraries WHERE Book_ID='$Book_ID'";
		$resultcoupon = $db->query($sqlcheckcoupon);
		$returnrow = $resultcoupon->fetch_assoc();
		$numrowscoupon = $returnrow["COUNT(*)"];

		if($Code_Limit>$numrowscoupon or $Code_Limit==0)
		{

			//Add book to users library
			if($numrows3==0)
			{
				$stmt = $db->stmt_init();
				if($_SESSION['usertype']!="parent")
				{
					$sql = "INSERT INTO books_libraries (User_ID, Book_ID) VALUES ('$userid', '$Book_ID');";
				}
				else
				{
					$sql = "INSERT INTO books_libraries (Parent_ID, Book_ID) VALUES ('$userid', '$Book_ID');";
				}
				$stmt->prepare($sql);
				$stmt->execute();
				$stmt->close();
				$db->close();
			}
			echo "The book is available in your library.";
		}
		else
		{
			echo "No licenses are available for this book.";
		}
	}

	if($numrows==0)
	{
		echo "Invalid book coupon.";
	}

?>