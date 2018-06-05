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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	//Add the course
	$course_title=mysqli_real_escape_string($db, $_POST["course_title"]);
	$course_grade=$_POST["course_grade"];
	$course_grade = implode (", ", $course_grade);
	$course_subject=$_POST["course_subject"];
	$course_editors=$_POST["course_editors"];
	$course_image="generic.jpg";
	if($course_subject=="Mathematics"){ $course_image="mathematics.jpg"; }
	if($course_subject=="Science"){ $course_image="science.jpg"; }
	if($course_subject=="Social Studies"){ $course_image="socialstudies.jpg"; }
	if($course_subject=="English Language Arts"){ $course_image="english.jpg"; }
	if($course_subject=="Technology"){ $course_image="generic.jpg"; }
	$course_id=$_POST["course_id"];
	$course_hidden=isset($_POST["course_hidden"]);
	if($course_hidden==""){ $course_hidden="0"; }

	if(isset($_POST['learn_course'])){ $learn_course = $_POST['learn_course']; }else{ $learn_course = 0; }
	if(isset($_POST['learnRestrictions'])){
		$restrictions = $_POST['learnRestrictions'];
		$restrictions = implode(",", $restrictions);
	}else{
		$restrictions = '';
	}

	if(isset($_POST['course_tags'])){ $course_tags = $_POST['course_tags']; }else{ $course_tags = ""; }
	if(isset($_POST['course_description'])){ $course_description = $_POST['course_description']; }else{ $course_description = ""; }
	if(isset($_POST['learn_sequential'])){ $learn_sequential = $_POST['learn_sequential']; }else{ $learn_sequential = 0; }

	//Add or update the course
	if($course_id == ""){
		$stmt = $db->stmt_init();
		$sql = "INSERT INTO curriculum_course (Hidden, Title, Description, Subject, Grade, Image, Editors, Learn_Course, Restrictions, Tags, Sequential) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt->prepare($sql);
		$stmt->bind_param("issssssissi", $course_hidden, $course_title, $course_description, $course_subject, $course_grade, $course_image, $course_editors, $learn_course, $restrictions, $course_tags, $learn_sequential);
		$stmt->execute();
		$stmt->close();
		$db->close();
	}else{
		$stmt = $db->stmt_init();
		$sql = "UPDATE curriculum_course SET Hidden = ?, Title = ?, Description = ?, Subject = ?, Grade = ?, Editors = ?, Learn_Course = ?, Restrictions = ?, Tags = ?, Sequential = ? WHERE ID = ?";
		$stmt->prepare($sql);
		$stmt->bind_param("isssssissii", $course_hidden, $course_title, $course_description, $course_subject, $course_grade, $course_editors, $learn_course, $restrictions, $course_tags, $learn_sequential, $course_id);
		$stmt->execute();
		$stmt->close();
		$db->close();
	}

	//Give message
	echo "The course has been saved.";

?>