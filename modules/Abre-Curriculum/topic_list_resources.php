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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	$topicid=$_GET["topicid"];
	$sqllookup6 = "SELECT Title, Link, ID, Type, `Text` FROM curriculum_resources WHERE TopicID=$topicid";
	$result7 = $db->query($sqllookup6);
	$resourcecount=mysqli_num_rows($result7);
	if($resourcecount!=0){ echo "<table style='width:100%;'>"; }
	while($row8 = $result7->fetch_assoc())
	{
			if (!empty($row8["Title"])){ $Unit_Resource_Title=htmlspecialchars($row8["Title"], ENT_QUOTES); }
			$Unit_Resource_Link=stripslashes($row8["Link"]);
			$Unit_Resource_ID=stripslashes($row8["ID"]);
			$Unit_Resource_Type=stripslashes($row8["Type"]);
			$Unit_Resource_Text=htmlspecialchars($row8["Text"], ENT_QUOTES);
			if($Unit_Resource_Link!=""){ $icon='link'; }
			if($Unit_Resource_Type=="Standard"){ $icon='trending_up'; }
			if (!empty($row8["Title"])){

				if($Unit_Resource_Type=="Standard"){

					$Unit_Resource_Title = mysqli_real_escape_string($db, $Unit_Resource_Title);

					//Check if standard contains period
					if (strpos($Unit_Resource_Title, ".") !== false){

						//If old method for using standards
						$sql = "SELECT State_Standard FROM curriculum_standards WHERE State_Standard='$Unit_Resource_Title'";
						$result = $db->query($sql);
						while($row = $result->fetch_assoc()){
							$Unit_Resource_Title=htmlspecialchars($row["State_Standard"], ENT_QUOTES);
						}

					}else{

						//If new method for using standards
						$sql = "SELECT standard_statementNotation, standard_description FROM Abre_Standards_Description WHERE standard_id='$Unit_Resource_Title'";
						$result = $db->query($sql);
						while($row = $result->fetch_assoc()){
							$Unit_Resource_Title=htmlspecialchars($row["standard_statementNotation"], ENT_QUOTES);
							$standard_description=htmlspecialchars($row["standard_description"], ENT_QUOTES);
							if($Unit_Resource_Title==""){ $Unit_Resource_Title=$standard_description; }
						}

					}

				}

			}
			if($Unit_Resource_Text!=""){ $icon='subject'; }

			$sqllookupcourse = "SELECT Course_ID FROM curriculum_unit WHERE ID=$topicid";
			$resultcourse = $db->query($sqllookupcourse);
			while($rowcourse = $resultcourse->fetch_assoc())
			{
				$Course_ID=stripslashes($rowcourse["Course_ID"]);
			}
			echo "<tr class='attachwrapper'>";
			if($Unit_Resource_Type == "Drive"){
				echo "<td style='border:1px solid #e1e1e1; width:70px; background-color:".getSiteColor()."'><img style='padding:6px 18px 6px 18px; margin:0; line-height:0;' src='../../core/images/abre/google-drive-light.png'></td><td style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
			}else{
				echo "<td style='border:1px solid #e1e1e1; width:70px; background-color:".getSiteColor()."'><i class='material-icons' style='padding:18px; margin:0; color:#fff; font-size: 24px; line-height:0;'>$icon</i></td><td style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
			}
			if($Unit_Resource_Link != NULL)
			{
				echo "<a href='$Unit_Resource_Link' target='_blank' class='mdl-color-text--black'>$Unit_Resource_Title</a>";
			}
			else
			{
				echo "<p class='mdl-color-text--black' style='font-weight:500'>$Unit_Resource_Title</p>";
			}

			if($Unit_Resource_Text!="")
			{
				echo "</td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'><a class='modal-texttopic' style='color: ".getSiteColor()."' href='#' data-courseid='$Course_ID' data-topicid='$topicid' data-resourceid='$Unit_Resource_ID' data-texttype='$Unit_Resource_Type' data-texttitle='$Unit_Resource_Title' data-texttext='$Unit_Resource_Text'><i class='material-icons'>mode_edit</i></a></td>";
			}
			else
			{
				echo "</td><td style='background-color:#F5F5F5; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'></td>";
			}
			echo "</td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'><a href='modules/".basename(__DIR__)."/topic_resource_remove.php?resourceid=".$Unit_Resource_ID."' class='attachdeletebutton' style='color: ".getSiteColor()."'><i class='material-icons'>clear</i></a></td></tr>";

	}
	if($resourcecount!=0){ echo "</table>"; }

	$LessonLookup_Query = "SELECT ID, Title, Body, Standards, Resources, Anticipatory, Objectives, DirectInstruction, GuidedPractice, IndependentPractice, FormativeAssessment, Closure FROM curriculum_lesson WHERE TopicID=$topicid";
	$LessonResults = $db->query($LessonLookup_Query);
	$LessonCount=mysqli_num_rows($LessonResults);
	if($LessonCount!=0){ echo "<table style='width:100%;'>"; }
	while($LessonRows = $LessonResults->fetch_assoc())
	{
			if (!empty($LessonRows["ID"])){ $Unit_Resource_ID=htmlspecialchars($LessonRows["ID"], ENT_QUOTES); }
			if (!empty($LessonRows["Title"])){ $Unit_Resource_Title=htmlspecialchars($LessonRows["Title"], ENT_QUOTES); }
			if (!empty($LessonRows["Body"]))
			{
				$Unit_Resource_Body=$LessonRows["Body"];
				if($Unit_Resource_Body!="")
				{
					$Unit_Resource_Body=base64_encode($Unit_Resource_Body);
				}
			}
			if (!empty($LessonRows["Standards"]))
			{
				$Unit_Resource_Standards=$LessonRows["Standards"];
				if($Unit_Resource_Standards!="")
				{
					$Unit_Resource_Standards=base64_encode($Unit_Resource_Standards);
				}
			}
			if (!empty($LessonRows["Resources"]))
			{
				$Unit_Resource_Resources=$LessonRows["Resources"];
				if($Unit_Resource_Resources!="")
				{
					$Unit_Resource_Resources=base64_encode($Unit_Resource_Resources);
				}
			}
			if (!empty($LessonRows["Anticipatory"]))
			{
				$Unit_Resource_Anticipatory=$LessonRows["Anticipatory"];
				if($Unit_Resource_Anticipatory!="")
				{
					$Unit_Resource_Anticipatory=base64_encode($Unit_Resource_Anticipatory);
				}
			}
			if (!empty($LessonRows["Objectives"]))
			{
				$Unit_Resource_Objectives=$LessonRows["Objectives"];
				if($Unit_Resource_Objectives!="")
				{
					$Unit_Resource_Objectives=base64_encode($Unit_Resource_Objectives);
				}
			}
			if (!empty($LessonRows["DirectInstruction"]))
			{
				$Unit_Resource_DirectInstruction=$LessonRows["DirectInstruction"];
				if($Unit_Resource_DirectInstruction!="")
				{
					$Unit_Resource_DirectInstruction=base64_encode($Unit_Resource_DirectInstruction);
				}
			}
			if (!empty($LessonRows["GuidedPractice"]))
			{
				$Unit_Resource_GuidedPractice=$LessonRows["GuidedPractice"];
				if($Unit_Resource_GuidedPractice!="")
				{
					$Unit_Resource_GuidedPractice=base64_encode($Unit_Resource_GuidedPractice);
				}
			}
			if (!empty($LessonRows["IndependentPractice"]))
			{
				$Unit_Resource_IndependentPractice=$LessonRows["IndependentPractice"];
				if($Unit_Resource_IndependentPractice!="")
				{
					$Unit_Resource_IndependentPractice=base64_encode($Unit_Resource_IndependentPractice);
				}
			}
			if (!empty($LessonRows["FormativeAssessment"]))
			{
				$Unit_Resource_FormativeAssessment=$LessonRows["FormativeAssessment"];
				if($Unit_Resource_FormativeAssessment!="")
				{
					$Unit_Resource_FormativeAssessment=base64_encode($Unit_Resource_FormativeAssessment);
				}
			}
			if (!empty($LessonRows["Closure"]))
			{
				$Unit_Resource_Closure=$LessonRows["Closure"];
				if($Unit_Resource_Closure!="")
				{
					$Unit_Resource_Closure=base64_encode($Unit_Resource_Closure);
				}
			}
			$icon='school';

			$sqllookupcourse = "SELECT Course_ID FROM curriculum_unit WHERE ID=$topicid";
			$resultcourse = $db->query($sqllookupcourse);
			while($rowcourse = $resultcourse->fetch_assoc())
			{
				$Course_ID=stripslashes($rowcourse["Course_ID"]);
			}
		echo "<tr class='attachwrapper'><td style='border:1px solid #e1e1e1; width:70px; background-color:".getSiteColor()."'><i class='material-icons' style='padding:18px; margin:0; color:#fff; font-size: 24px; line-height:0;'>$icon</i></td><td style='background-color:#F5F5F5; border-left:1px solid #e1e1e1; border-top:1px solid #e1e1e1; border-bottom:1px solid #e1e1e1; padding:10px;'>";
			echo "<a href='#curriculum/lesson/$topicid/$Course_ID/$Unit_Resource_ID' class='mdl-color-text--black clickonlesson'>$Unit_Resource_Title</a>";
			echo "</td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'><a class='modal-lessontopic' style='color: ".getSiteColor()."' href='#' data-courseid='$Course_ID' data-topicid='$topicid' data-resourceid='$Unit_Resource_ID' data-title='$Unit_Resource_Title' data-body='$Unit_Resource_Body' data-standards='$Unit_Resource_Standards' data-resources='$Unit_Resource_Resources' data-anticipatory='$Unit_Resource_Anticipatory' data-objectives='$Unit_Resource_Objectives' data-directinstruction='$Unit_Resource_DirectInstruction' data-guidedpractice='$Unit_Resource_GuidedPractice' data-independentpractice='$Unit_Resource_IndependentPractice' data-formativeassessment='$Unit_Resource_FormativeAssessment' data-closure='$Unit_Resource_Closure'><i class='material-icons'>mode_edit</i></a></td>";

			echo "</td><td style='background-color:#F5F5F5; border:1px solid #e1e1e1; padding:12px 10px 10px 22px; width:70px;'><a href='modules/".basename(__DIR__)."/topic_lesson_remove.php?resourceid=".$Unit_Resource_ID."' class='attachdeletebutton' style='color: ".getSiteColor()."'><i class='material-icons'>clear</i></a></td></tr>";

	}
	if($LessonCount!=0){ echo "</table>"; }

?>

<script>

	$(function()
	{

		$( ".clickonlesson" ).unbind().click(function() {
			$('#curriculumtopic').closeModal({ out_duration: 0 });
		});

		$( ".attachdeletebutton" ).unbind().click(function() {

			var resultclick = confirm("Are you sure you want to delete?");
			if (resultclick) {
				event.preventDefault();
				$(this).closest(".attachwrapper").hide();
				var address = $(this).attr("href");
				$.ajax({
					type: 'POST',
					url: address,
					data: '',
				})

				.done(function(response) {
					$("#attacheditem_"+response).closest("tr").hide();
					$("#attacheditem_"+response).hide();
					$("#modellesson_"+response).hide();
				});
			}
			return false;
		});

	});

</script>
