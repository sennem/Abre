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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');

	//Display pacing guide
	if($pagerestrictions=="")
	{

		//List Attached Standards
		$sqllookup3 = "SELECT Title, ID FROM curriculum_resources WHERE Type='Standard' AND TopicID=$Unit_ID";
		$result4 = $db->query($sqllookup3);
		$standardcount=mysqli_num_rows($result4);
		if($standardcount!=0){ echo "<br><span style='color:#777'>Standards</span><br>"; }
		while($row3 = $result4->fetch_assoc())
		{
			$Title=htmlspecialchars($row3["Title"], ENT_QUOTES);
			$ID=htmlspecialchars($row3["ID"], ENT_QUOTES);

			//Check if standard contains period
			if (strpos($Title, ".") !== false){

				//Old Method
				$sqllookup5 = "SELECT Standard_ID, State_Standard FROM curriculum_standards WHERE Standard_ID='$Title' LIMIT 1";
				$result7 = $db->query($sqllookup5);
				while($row9 = $result7->fetch_assoc())
				{
					$State_Standard=mysqli_real_escape_string($db, $row9["State_Standard"]);
					$State_Standard=utf8_encode($State_Standard);
					$State_StandardNotation=mysqli_real_escape_string($db, $row9["Standard_ID"]);
					$State_StandardNotation=utf8_encode($State_StandardNotation);
					if($State_StandardNotation==""){ $State_StandardNotation="Standard $standardcount"; }
					echo "<div id='attacheditem_$ID' style='display:inline-block; padding:10px; margin:0 3px 3px 0; color:#fff; font-weight:400; box-shadow: none !important;' class='$bgcolor pointer card'>$State_StandardNotation</div>";
					echo "<div class='mdl-tooltip mdl-tooltip--bottom mdl-tooltip--large' for='attacheditem_$ID'>$State_Standard</div>";
				}

		}else{

				//New Method
				$sqllookup5 = "SELECT standard_statementNotation, standard_description, standard_id FROM Abre_Standards_Description WHERE standard_id='$Title' LIMIT 1";
				$result7 = $db->query($sqllookup5);
				while($row9 = $result7->fetch_assoc())
				{
					$State_Standard=$row9["standard_description"];
					$State_StandardNotation=mysqli_real_escape_string($db, $row9["standard_statementNotation"]);
					$State_StandardNotation=utf8_encode($State_StandardNotation);
					if($State_StandardNotation==""){ $State_StandardNotation="Standard $standardcount"; }
					echo "<div id='attacheditem_$ID' style='display:inline-block; padding:10px; margin:0 3px 3px 0; color:#fff; font-weight:400; box-shadow: none !important;' class='$bgcolor pointer card'>$State_StandardNotation</div>";
					echo "<div class='mdl-tooltip mdl-tooltip--bottom mdl-tooltip--large' for='attacheditem_$ID'>$State_Standard</div>";
				}

			}

			$Unit_Standards=1;
		}
		if($standardcount!=0){ echo "<br>"; }

		//List resources
		$sqllookup6 = "SELECT Title, Link, ID, `Text`, Type FROM curriculum_resources WHERE (Type = 'Resource' OR Type = 'Drive') AND TopicID = $Unit_ID";
		$result7 = $db->query($sqllookup6);
		$resourcecount=mysqli_num_rows($result7);
		if($resourcecount!=0){ echo "<br><span style='color:#777'>Resources</span><br><table style='width:100%;'>"; }
		while($row8 = $result7->fetch_assoc())
		{
			$Unit_Resource_Title = htmlspecialchars($row8["Title"], ENT_QUOTES);
			$Unit_Resource_Link = htmlspecialchars($row8["Link"], ENT_QUOTES);
			$Unit_Resource_ID = htmlspecialchars($row8["ID"], ENT_QUOTES);
			$Unit_Resource_Link = htmlspecialchars($row8["Link"], ENT_QUOTES);
			$Unit_Resource_Type = htmlspecialchars($row8["Type"], ENT_QUOTES);
			if($Unit_Resource_Link!=""){ $icon='link'; }
			$Unit_Resource_Text=nl2br($row8["Text"]);

			if($Unit_Resource_Text!=""){ $icon='subject'; }
			if($Unit_Resource_Type == "Drive"){
				echo "<tr id='attacheditem_$Unit_Resource_ID'><td style='border:1px solid #e1e1e1; width:70px;' class='$bgcolor'><img class='material-icons' style='padding:6px 18px 6px 18px; margin:0; line-height:0;' src='../../core/images/abre/google-drive-light.png'></td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:10px;'>";
			}else{
				echo "<tr id='attacheditem_$Unit_Resource_ID'><td style='border:1px solid #e1e1e1; width:70px;' class='$bgcolor'><i class='material-icons' style='padding:18px; margin:0; color:#fff; font-size: 24px; line-height:0;'>$icon</i></td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:10px;'>";
			}
			if($Unit_Resource_Text=="")
			{
				echo "<a href='$Unit_Resource_Link' target='_blank' class='mdl-color-text--black'>$Unit_Resource_Title</a>";
			}
			else
			{
				$Unit_Resource_Text=linkify($Unit_Resource_Text);
				echo "<span style='font-weight:500;' class='mdl-color-text--black'>$Unit_Resource_Title</span>";
			}
			if($Unit_Resource_Text!=""){ echo "<p style='padding:10px 0 0 0;'>$Unit_Resource_Text</p>"; }
			echo "</td></tr>";
		}
		if($resourcecount!=0){ echo "</table>"; }

		//List assessments
		$sqllookup6 = "SELECT Title, Link, ID, `Text` FROM curriculum_resources WHERE Type='Assessment' AND TopicID=$Unit_ID";
		$result7 = $db->query($sqllookup6);
		$assessmentcount=mysqli_num_rows($result7);
		if($assessmentcount!=0){ echo "<br><span style='color:#777'>Assessments</span><br><table style='width:100%;'>"; }
		while($row8 = $result7->fetch_assoc())
		{
			$Unit_Resource_Title=htmlspecialchars($row8["Title"], ENT_QUOTES);
			$Unit_Resource_Link=htmlspecialchars($row8["Link"], ENT_QUOTES);
			$Unit_Resource_ID=htmlspecialchars($row8["ID"], ENT_QUOTES);
			$Unit_Resource_Link=htmlspecialchars($row8["Link"], ENT_QUOTES);
			if($Unit_Resource_Link!=""){ $icon='link'; }
			$Unit_Resource_Text=nl2br($row8["Text"]);
			if($Unit_Resource_Text!=""){ $icon='subject'; }
			echo "<tr id='attacheditem_$Unit_Resource_ID'><td style='border:1px solid #e1e1e1; width:70px;' class='$bgcolor'><i class='material-icons' style='padding:18px; margin:0; color:#fff; font-size: 24px; line-height:0;'>$icon</i></td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:10px;'>";
			if($Unit_Resource_Text=="")
			{
				echo "<a href='$Unit_Resource_Link' target='_blank' class='mdl-color-text--black'>$Unit_Resource_Title</a>";
			}
			else
			{
				echo "<span style='font-weight:500;' class='mdl-color-text--black'>$Unit_Resource_Title</span>";
			}
			if($Unit_Resource_Text!="")
			{
				$Unit_Resource_Text=linkify($Unit_Resource_Text);
				echo "<p style='padding:10px 0 0 0;'>$Unit_Resource_Text</p>";
			}
			echo "</td></tr>";
		}
		if($assessmentcount!=0){ echo "</table>"; }

		//List lessons
		$sqllookup6 = "SELECT Title, Link, ID, `Text` FROM curriculum_resources WHERE Type='Lesson' AND TopicID=$Unit_ID";
		$result7 = $db->query($sqllookup6);
		$lessoncount=mysqli_num_rows($result7);
		if($lessoncount!=0){ echo "<br><span style='color:#777'>Lessons</span><br><table style='width:100%;'>"; }
		while($row8 = $result7->fetch_assoc())
		{
			$Unit_Resource_Title=htmlspecialchars($row8["Title"], ENT_QUOTES);
			$Unit_Resource_Link=htmlspecialchars($row8["Link"], ENT_QUOTES);
			$Unit_Resource_ID=htmlspecialchars($row8["ID"], ENT_QUOTES);
			$Unit_Resource_Link=htmlspecialchars($row8["Link"], ENT_QUOTES);
			if($Unit_Resource_Link!=""){ $icon='link'; }
			$Unit_Resource_Text=nl2br($row8["Text"]);
			if($Unit_Resource_Text!=""){ $icon='subject'; }
			echo "<tr id='attacheditem_$Unit_Resource_ID'><td style='border:1px solid #e1e1e1; width:70px;' class='$bgcolor'><i class='material-icons' style='padding:18px; margin:0; color:#fff; font-size: 24px; line-height:0;'>$icon</i></td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:10px;'>";
			if($Unit_Resource_Text=="")
			{
				echo "<a href='$Unit_Resource_Link' target='_blank' class='mdl-color-text--black'>$Unit_Resource_Title</a>";
			}
			else
			{
				$Unit_Resource_Text=linkify($Unit_Resource_Text);
				echo "<span style='font-weight:500;' class='mdl-color-text--black'>$Unit_Resource_Title</span>";
			}
			if($Unit_Resource_Text!=""){ echo "<p style='padding:10px 0 0 0;'>$Unit_Resource_Text</p>"; }
			echo "</td></tr>";
		}
		if($lessoncount!=0){ echo "</table>"; }

		//List MODEL lessons
		$sqllookup9 = "SELECT Title, ID FROM curriculum_lesson WHERE TopicID=$Unit_ID";
		$result9 = $db->query($sqllookup9);
		$modellessoncount=mysqli_num_rows($result9);
		if($modellessoncount!=0){ echo "<br><span style='color:#777'>Model Lessons</span><br><table style='width:100%;'>"; }
		while($row9 = $result9->fetch_assoc())
		{
			$ModelLesson_Title=htmlspecialchars($row9["Title"], ENT_QUOTES);
			$ModelLesson_ID=htmlspecialchars($row9["ID"], ENT_QUOTES);
			echo "<tr id='modellesson_$ModelLesson_ID'><td style='border:1px solid #e1e1e1; width:70px;' class='$bgcolor'><i class='material-icons' style='padding:18px; margin:0; color:#fff; font-size: 24px; line-height:0;'>school</i></td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:10px;'>";
			echo "<a href='#curriculum/lesson/$Unit_ID/$Course_ID/$ModelLesson_ID' class='mdl-color-text--black'>$ModelLesson_Title</a>";
			echo "</td></tr>";
		}
		if($modellessoncount!=0){ echo "</table>"; }
	}

?>
