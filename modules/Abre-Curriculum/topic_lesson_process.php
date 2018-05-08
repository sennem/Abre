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
	$lesson_estimated_days=mysqli_real_escape_string($db, $_POST["lesson_number_text_content"]);
	
	$lesson_standards_text_content=mysqli_real_escape_string($db, $_POST["lesson_standards_text_content"]);
	$lesson_standards_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_standards_text_content_html"]);
	
	$lesson_resources_text_content=mysqli_real_escape_string($db, $_POST["lesson_resources_text_content"]);
	$lesson_resources_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_resources_text_content_html"]);
	
	$lesson_anticipatory_set_text_content=mysqli_real_escape_string($db, $_POST["lesson_anticipatory_set_text_content"]);
	$lesson_anticipatory_set_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_anticipatory_set_text_content_html"]);
	
	$lesson_learning_objectives_text_content=mysqli_real_escape_string($db, $_POST["lesson_learning_objectives_text_content"]);
	$lesson_learning_objectives_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_learning_objectives_text_content_html"]);
	
	$lesson_direct_instruction_text_content=mysqli_real_escape_string($db, $_POST["lesson_direct_instruction_text_content"]);
	$lesson_direct_instruction_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_direct_instruction_text_content_html"]);
	
	$lesson_guided_practice_text_content=mysqli_real_escape_string($db, $_POST["lesson_guided_practice_text_content"]);
	$lesson_guided_practice_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_guided_practice_text_content_html"]);
	
	$lesson_independent_practice_text_content=mysqli_real_escape_string($db, $_POST["lesson_independent_practice_text_content"]);
	$lesson_independent_practice_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_independent_practice_text_content_html"]);
	
	$lesson_formative_assessment_text_content=mysqli_real_escape_string($db, $_POST["lesson_formative_assessment_text_content"]);
	$lesson_formative_assessment_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_formative_assessment_text_content_html"]);
	
	$lesson_closure_text_content=mysqli_real_escape_string($db, $_POST["lesson_closure_text_content"]);
	$lesson_closure_text_content_html=mysqli_real_escape_string($db, $_POST["lesson_closure_text_content_html"]);
	$stmt = $db->stmt_init();
	if($resourceid=="")
	{
		$sql = "INSERT INTO curriculum_lesson (
		TopicID, 
		Title, 
		Number, 
		Standards_WYSIWYG, 
		Standards, 
		Resources_WYSIWYG, 
		Resources, 
		Anticipatory_WYSIWYG, 
		Anticipatory, 
		Objectives_WYSIWYG, 
		Objectives, 
		DirectInstruction_WYSIWYG, 
		DirectInstruction, 
		GuidedPractice_WYSIWYG, 
		GuidedPractice, 
		IndependentPractice_WYSIWYG, 
		IndependentPractice, 
		FormativeAssessment_WYSIWYG, 
		FormativeAssessment, 
		Closure_WYSIWYG, 
		Closure) VALUES (
		'$topic_id', 
		'$topic_lesson_title', 
		'$lesson_estimated_days', 
		'$lesson_standards_text_content', 
		'$lesson_standards_text_content_html', 
		'$lesson_resources_text_content', 
		'$lesson_resources_text_content_html', 
		'$lesson_anticipatory_set_text_content', 
		'$lesson_anticipatory_set_text_content_html', 
		'$lesson_learning_objectives_text_content', 
		'$lesson_learning_objectives_text_content_html', 
		'$lesson_direct_instruction_text_content', 
		'$lesson_direct_instruction_text_content_html', 
		'$lesson_guided_practice_text_content', 
		'$lesson_guided_practice_text_content_html', 
		'$lesson_independent_practice_text_content', 
		'$lesson_independent_practice_text_content_html', 
		'$lesson_formative_assessment_text_content', 
		'$lesson_formative_assessment_text_content_html', 
		'$lesson_closure_text_content', 
		'$lesson_closure_text_content_html'
		);";
	}
	else
	{
		$sql = "UPDATE curriculum_lesson set 
		Title='$topic_lesson_title', 
		Number='$lesson_estimated_days', 
		Standards_WYSIWYG='$lesson_standards_text_content', 
		Standards='$lesson_standards_text_content_html', 
		Resources_WYSIWYG='$lesson_resources_text_content', 
		Resources='$lesson_resources_text_content_html', 
		Anticipatory_WYSIWYG='$lesson_anticipatory_set_text_content', 
		Anticipatory='$lesson_anticipatory_set_text_content_html', 
		Objectives_WYSIWYG='$lesson_learning_objectives_text_content', 
		Objectives='$lesson_learning_objectives_text_content_html', 
		DirectInstruction_WYSIWYG='$lesson_direct_instruction_text_content', 
		DirectInstruction='$lesson_direct_instruction_text_content_html', 
		GuidedPractice_WYSIWYG='$lesson_guided_practice_text_content', 
		GuidedPractice='$lesson_guided_practice_text_content_html', 
		IndependentPractice_WYSIWYG='$lesson_independent_practice_text_content', 
		IndependentPractice='$lesson_independent_practice_text_content_html', 
		FormativeAssessment_WYSIWYG='$lesson_formative_assessment_text_content', 
		FormativeAssessment='$lesson_formative_assessment_text_content_html', 
		Closure_WYSIWYG='$lesson_closure_text_content',
		Closure='$lesson_closure_text_content_html'
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