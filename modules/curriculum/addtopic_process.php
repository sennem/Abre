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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	
	//Add the Book
	$topic_title=$_POST["topic_title"];
	$topic_theme=$_POST["topic_theme"];
	$topic_start_time=$_POST["topic_start_time"];
	$topic_estimated_days=$_POST["topic_estimated_days"];
	$courseid=$_POST["courseid"];
	$stmt = $db->stmt_init();
	$sql = "INSERT INTO curriculum_unit (Course_ID, Title, Description, Start_Time, Length) VALUES ('$courseid', '$topic_title', '$topic_theme', '$topic_start_time', '$topic_estimated_days');";
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->close();
	$db->close();
	echo "The topic has been added to the curriculum";
	
?>