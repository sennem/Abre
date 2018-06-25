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

	//Add the topic
	$topic_id=$_POST["topicID"];
	$courseid=$_POST["courseID"];
	$resourceid=$_POST["resourceID"];
	$topic_lesson_title=mysqli_real_escape_string($db, $_POST["topic_lesson_title"]);
	$wysiwyg_body=mysqli_real_escape_string($db, $_POST["wysiwyg_body"]);
	$wysiwyg_standards=mysqli_real_escape_string($db, $_POST["wysiwyg_standards"]);
	$wysiwyg_resources=mysqli_real_escape_string($db, $_POST["wysiwyg_resources"]);
	$wysiwyg_anticipatory=mysqli_real_escape_string($db, $_POST["wysiwyg_anticipatory"]);
	$wysiwyg_objectives=mysqli_real_escape_string($db, $_POST["wysiwyg_objectives"]);
	$wysiwyg_directinstruction=mysqli_real_escape_string($db, $_POST["wysiwyg_directinstruction"]);
	$wysiwyg_guidedpractice=mysqli_real_escape_string($db, $_POST["wysiwyg_guidedpractice"]);
	$wysiwyg_independentpractice=mysqli_real_escape_string($db, $_POST["wysiwyg_independentpractice"]);
	$wysiwyg_formativeassessment=mysqli_real_escape_string($db, $_POST["wysiwyg_formativeassessment"]);
	$wysiwyg_closure=mysqli_real_escape_string($db, $_POST["wysiwyg_closure"]);

	$stmt = $db->stmt_init();
	if($resourceid=="")
	{
		$sql = "INSERT INTO curriculum_lesson
		(
			TopicID,
			Title,
			Body,
			Standards,
			Resources,
			Anticipatory,
			Objectives,
			DirectInstruction,
			GuidedPractice,
			IndependentPractice,
			FormativeAssessment,
			Closure
		)
		VALUES
		(
			'$topic_id',
			'$topic_lesson_title',
			'$wysiwyg_body',
			'$wysiwyg_standards',
			'$wysiwyg_resources',
			'$wysiwyg_anticipatory',
			'$wysiwyg_objectives',
			'$wysiwyg_directinstruction',
			'$wysiwyg_guidedpractice',
			'$wysiwyg_independentpractice',
			'$wysiwyg_formativeassessment',
			'$wysiwyg_closure'
		);";
	}
	else
	{
		$sql = "UPDATE curriculum_lesson set
		Title='$topic_lesson_title',
		Body='$wysiwyg_body',
		Standards='$wysiwyg_standards',
		Resources='$wysiwyg_resources',
		Anticipatory='$wysiwyg_anticipatory',
		Objectives='$wysiwyg_objectives',
		DirectInstruction='$wysiwyg_directinstruction',
		GuidedPractice='$wysiwyg_guidedpractice',
		IndependentPractice='$wysiwyg_independentpractice',
		FormativeAssessment='$wysiwyg_formativeassessment',
		Closure='$wysiwyg_closure'
		WHERE ID='$resourceid';";

	}
	$stmt->prepare($sql);
	$stmt->execute();
	$stmt->close();
	$db->close();

	$person = array("topicid"=>$topic_id,"courseid"=>$courseid,"message"=>"The lesson has been added.");
	header("Content-Type: application/json");
	echo json_encode($person);

?>
