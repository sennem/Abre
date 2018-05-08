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
	$course_id=mysqli_real_escape_string($db, $_POST["courseIDduplicateid"]);

	if($course_id!="")
	{

		//Duplicate the course
		$sqllookup2 = "SELECT ID, Title, Level, Subject, Grade, Image FROM curriculum_course WHERE ID='$course_id'";
		$result3 = $db->query($sqllookup2);
		while($row2 = $result3->fetch_assoc())
		{
			$Course_ID=$row2["ID"];
			$Course_Title=$row2["Title"];
			$Course_Title="$Course_Title - Duplicated";
			$Course_Level=$row2["Level"];
			$Course_Subject=$row2["Subject"];
			$Course_Grade=$row2["Grade"];
			$Course_Image=$row2["Image"];

			$stmt = $db->stmt_init();
			$sql = "INSERT INTO curriculum_course (Title, Level, Subject, Grade, Image) VALUES ('$Course_Title', '$Course_Level', '$Course_Subject', '$Course_Grade', '$Course_Image');";
			$stmt->prepare($sql);
			$stmt->execute();
			$new_courseID = $stmt->insert_id;
			$stmt->close();

			//Duplicate the topics
			$sqllookupres = "SELECT ID, Title, Start_Time, Length, Description FROM curriculum_unit WHERE Course_ID='$Course_ID'";
			$resultres = $db->query($sqllookupres);
			while($rowres = $resultres->fetch_assoc())
			{
				$Topic_ID=$rowres["ID"];
				$Topic_Title=$rowres["Title"];
				$Topic_Start_Time=$rowres["Start_Time"];
				$Topic_Length=$rowres["Length"];
				$Topic_Description=$rowres["Description"];


				$stmt = $db->stmt_init();
				$sql2 = "INSERT INTO curriculum_unit (Course_ID, Title, Start_Time, Length, Description) VALUES ('$new_courseID', '$Topic_Title', '$Topic_Start_Time', '$Topic_Length', '$Topic_Description');";
				$stmt->prepare($sql2);
				$stmt->execute();
				$new_topicID = $stmt->insert_id;
				$stmt->close();


				//Duplicate the resources
				$sqllookupresources = "SELECT Type, Title, Link, `Text` FROM curriculum_resources WHERE TopicID='$Topic_ID'";
				$resultresources = $db->query($sqllookupresources);
				while($rowresources = $resultresources->fetch_assoc())
				{

					$Resource_Type=$rowresources["Type"];
					$Resource_Title=$rowresources["Title"];
					$Resource_Link=$rowresources["Link"];
					$Resource_Text=$rowresources["Text"];


					$stmt = $db->stmt_init();
					$sql3 = "INSERT INTO curriculum_resources (TopicID, Type, Title, Link, `Text`) VALUES ('$new_topicID', '$Resource_Type', '$Resource_Title', '$Resource_Link', '$Resource_Text');";
					$stmt->prepare($sql3);
					$stmt->execute();
					$stmt->close();
				}

				//Duplicate the lessons
				$sqllookuplessons = "SELECT Title, `Number`, Standards_WYSIWYG, Standards, Resources_WYSIWYG, Resources, Anticipatory_WYSIWYG, Anticipatory, Objectives_WYSIWYG, Objectives, DirectInstruction_WYSIWYG, DirectInstruction, GuidedPractice_WYSIWYG, GuidedPractice, IndependentPractice_WYSIWYG, IndependentPractice, FormativeAssessment_WYSIWYG, FormativeAssessment, Closure_WYSIWYG, Closure FROM curriculum_lesson WHERE TopicID='$Topic_ID'";
				$resultlessons= $db->query($sqllookuplessons);
				while($rowlessons = $resultlessons->fetch_assoc())
				{

					$Lesson_Title=$rowlessons["Title"];
					$Lesson_Number=$rowlessons["Number"];
					$Lesson_Standards_WYSIWYG=$rowlessons["Standards_WYSIWYG"];
					$Lesson_Standards=$rowlessons["Standards"];
					$Lesson_Resources_WYSIWYG=$rowlessons["Resources_WYSIWYG"];
					$Lesson_Resources=$rowlessons["Resources"];
					$Lesson_Anticipatory_WYSIWYG=$rowlessons["Anticipatory_WYSIWYG"];
					$Lesson_Anticipatory=$rowlessons["Anticipatory"];
					$Lesson_Objectives_WYSIWYG=$rowlessons["Objectives_WYSIWYG"];
					$Lesson_Objectives=$rowlessons["Objectives"];
					$Lesson_DirectInstruction_WYSIWYG=$rowlessons["DirectInstruction_WYSIWYG"];
					$Lesson_DirectInstruction=$rowlessons["DirectInstruction"];
					$Lesson_GuidedPractice_WYSIWYG=$rowlessons["GuidedPractice_WYSIWYG"];
					$Lesson_GuidedPractice=$rowlessons["GuidedPractice"];
					$Lesson_IndependentPractice_WYSIWYG=$rowlessons["IndependentPractice_WYSIWYG"];
					$Lesson_IndependentPractice=$rowlessons["IndependentPractice"];
					$Lesson_FormativeAssessment_WYSIWYG=$rowlessons["FormativeAssessment_WYSIWYG"];
					$Lesson_FormativeAssessment=$rowlessons["FormativeAssessment"];
					$Lesson_Closure_WYSIWYG=$rowlessons["Closure_WYSIWYG"];
					$Lesson_Closure=$rowlessons["Closure"];


					$stmt = $db->stmt_init();
					$sql4 = "INSERT INTO curriculum_lesson (TopicID, Title, `Number`, Standards_WYSIWYG, Standards, Resources_WYSIWYG, Resources, Anticipatory_WYSIWYG, Anticipatory, Objectives_WYSIWYG, Objectives, DirectInstruction_WYSIWYG, DirectInstruction, GuidedPractice_WYSIWYG, GuidedPractice, IndependentPractice_WYSIWYG, 	IndependentPractice, FormativeAssessment_WYSIWYG, FormativeAssessment, Closure_WYSIWYG, Closure) VALUES ('$new_topicID', '$Lesson_Title', '$Lesson_Number', '$Lesson_Standards_WYSIWYG', '$Lesson_Standards', '$Lesson_Resources_WYSIWYG', '$Lesson_Resources', '$Lesson_Anticipatory_WYSIWYG', '$Lesson_Anticipatory', '$Lesson_Objectives_WYSIWYG', '$Lesson_Objectives', '$Lesson_DirectInstruction_WYSIWYG', '$Lesson_DirectInstruction', '$Lesson_GuidedPractice_WYSIWYG', '$Lesson_GuidedPractice', '$Lesson_IndependentPractice_WYSIWYG', '$Lesson_IndependentPractice', '$Lesson_FormativeAssessment_WYSIWYG', '$Lesson_FormativeAssessment', '$Lesson_Closure_WYSIWYG', '$Lesson_Closure');";
					$stmt->prepare($sql4);
					$stmt->execute();
					$stmt->close();
				}


			}

		}
		$db->close();

	}

	echo "The course has been duplicated.";

?>