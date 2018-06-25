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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');

	//Display pacing guide
	if($pagerestrictions=="")
	{

		if(isset($_GET["unitid"])){ $Captured_Unit_ID=htmlspecialchars($_GET["unitid"], ENT_QUOTES); }else{ $Captured_Unit_ID=""; }
		$Course_ID=htmlspecialchars($_GET["id"], ENT_QUOTES);
		$Course_TopicID=htmlspecialchars(isset($_GET["topicid"]), ENT_QUOTES);
		$foundactive=0;

		//Current Year
		$currentyear=date("Y");

		//Check to see if logged in person can edit this course
		$useremail=$_SESSION['useremail'];
		$sqllogin = "SELECT * FROM curriculum_course WHERE ID='$Course_ID' AND Editors LIKE '%$useremail%'";
		$resultlogin = $db->query($sqllogin);
		while($rowlogin = $resultlogin->fetch_assoc())
		{
			$pagerestrictionsedit="";
		}

		if($pagerestrictionsedit=="")
		{
			$sqllookup = "SELECT Title, Grade, Subject FROM curriculum_course WHERE ID='$Course_ID'";
			$active='no';
		}
		else
		{
			$sqllookup = "SELECT Title, Grade, Subject FROM curriculum_course WHERE ID='$Course_ID' AND Hidden='0'";
			$active='yes';
		}
		$result2 = $db->query($sqllookup);
		$setting_preferences=mysqli_num_rows($result2);
		while($row = $result2->fetch_assoc())
		{

			$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
			$Grade=htmlspecialchars($row["Grade"], ENT_QUOTES);
			$Subject=htmlspecialchars($row["Subject"], ENT_QUOTES);

			echo "<div class='page_container'>";
				echo "<div class='row'><div class='center-align' style='padding:20px;'><h3 style='font-weight:600;'>$Title</h3><h6 style='color:#777;'>$Subject &#183; Grade Level: $Grade</h6></div></div>";

				echo "<ul class='collapsible popout'>";

					$sqllookup2 = "SELECT ID, Title, Start_Time, Start_Time_Month, Start_Time_Day, Length, Description, Standards, Assessments, Lessons FROM `curriculum_unit` WHERE `Course_ID` = '$Course_ID' ORDER BY Start_Time, Title, FIELD( Start_Time_Month, 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul' )";
					$result3 = $db->query($sqllookup2);
					$unitcount=mysqli_num_rows($result3);
					while($row2 = $result3->fetch_assoc())
					{
						if (!empty($row2["ID"])){ $Unit_ID=htmlspecialchars($row2["ID"], ENT_QUOTES); }
						if (!empty($row2["Title"])){ $Unit_Title=htmlspecialchars($row2["Title"], ENT_QUOTES); }
						if (!empty($row2["Start_Time"])){
							$Unit_Start_Time=htmlspecialchars($row2["Start_Time"], ENT_QUOTES);
							$Unit_Start_Time=date("j F, Y", strtotime($Unit_Start_Time));
							$Unit_Start_Time_Year = substr($Unit_Start_Time, -4);
						}else{ $Unit_Start_Time="-"; $Unit_Start_Time_Year=""; }
						if (!empty($row2["Start_Time_Month"])){ $Unit_Start_Month=htmlspecialchars($row2["Start_Time_Month"], ENT_QUOTES); }else{ $Unit_Start_Month="-"; }
						if (!empty($row2["Start_Time_Day"])){ $Unit_Start_Day=htmlspecialchars($row2["Start_Time_Day"], ENT_QUOTES); }else{ $Unit_Start_Day=""; }
						if (!empty($row2["Length"])){ $Unit_Length=htmlspecialchars($row2["Length"], ENT_QUOTES); }else{ $Unit_Length="-"; }
						if (!empty($row2["Description"])){ $Unit_Description=htmlspecialchars($row2["Description"], ENT_QUOTES); }else{ $Unit_Description="New Theme"; }
						if (!empty($row2["Standards"])){ $Unit_Standards=htmlspecialchars($row2["Standards"], ENT_QUOTES); }
						if (!empty($row2["Assessments"])){ $Unit_Assessments=htmlspecialchars($row2["Assessments"], ENT_QUOTES); }
						if (!empty($row2["Lessons"])){ $Unit_Lessons=htmlspecialchars($row2["Lessons"], ENT_QUOTES); }
						$Current_Month = date('M');
						$Previous_Month = date('M', strtotime('-1 month'));
						$FormattedMonth=strtoupper($Unit_Start_Month);
						if($Unit_Start_Time_Year!=""){ $PreviewDate=strtoupper("$Unit_Start_Month $Unit_Start_Day, $Unit_Start_Time_Year"); }else{ $PreviewDate=""; }

						echo "<li style='position:relative' class='topicholder'>";

							if($Captured_Unit_ID!=$Unit_ID)
							{

							    if(($Current_Month==$Unit_Start_Month && $currentyear==$Unit_Start_Time_Year))
							    {
								    if($Course_TopicID==$Unit_ID or $Course_TopicID=="")
								    {
								    	if($active=='yes'){ echo "<div class='collapsible-header unit active scrollmarker'>"; }else{ echo "<div class='collapsible-header unit scrollmarker'>"; }
								    	$foundactive=1;
								    }
								    else
								    {
									    echo "<div class='collapsible-header unit'>";
								    }
							    	echo "<i class='material-icons mdl-color-text--green' style='font-size: 36px;'>fiber_manual_record</i>";
							    	$bgcolor="mdl-color--green";
							    	$textcolor="mdl-color-text--green";
							    }
							    else
							    {
								    if($Course_TopicID!=$Unit_ID)
								    {
								    	echo "<div class='collapsible-header unit' style='position:relative'>";
								    }
								    else
								    {
									    if($active=='yes'){ echo "<div class='collapsible-header unit active scrollmarker' style='position:relative'>"; }else{ echo "<div class='collapsible-header unit scrollmarker' style='position:relative'>"; }
									    $foundactive=1;
								    }
								    echo "<i class='material-icons mdl-color-text--red' style='font-size: 36px;'>fiber_manual_record</i>";
								    $bgcolor="mdl-color--red";
							    	$textcolor="mdl-color-text--red";
							    }

							}
							else
							{
								if(($Current_Month==$Unit_Start_Month && $currentyear==$Unit_Start_Time_Year))
							    {
								    if($active=='yes'){ echo "<div class='collapsible-header unit active scrollmarker'>"; }else{ echo "<div class='collapsible-header unit scrollmarker'>"; }
								    $foundactive=1;
									echo "<i class='material-icons mdl-color-text--green' style='font-size: 36px;'>fiber_manual_record</i>";
									$bgcolor="mdl-color--green";
									$textcolor="mdl-color-text--green";
								}
								else
								{
									if($active=='yes'){ echo "<div class='collapsible-header unit active scrollmarker'>"; }else{ echo "<div class='collapsible-header unit scrollmarker'>"; }
									$foundactive=1;
									echo "<i class='material-icons mdl-color-text--red' style='font-size: 36px;'>fiber_manual_record</i>";
									$bgcolor="mdl-color--red";
							    	$textcolor="mdl-color-text--red";
								}
							}

							echo "<span class='title truncate' style='margin-right:150px;'><b>$Unit_Title</b></span>";

							//Display Month/Time
							echo "<span style='position:absolute; top:0px; right:50px; z-index:1000;'>$PreviewDate</span>";

							if($pagerestrictionsedit=="")
							{
								echo "<span style='position:absolute; top:0px; right:10px; z-index:1000;' class='menuui'>";
									echo "<button id='demo-menu-bottom-left-$Unit_ID' class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-js-ripple-effect mdl-color-text--grey-700'><i class='material-icons'>more_vert</i></button>";
									echo "<ul class='mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect' for='demo-menu-bottom-left-$Unit_ID'>";
										echo "<li class='mdl-menu__item modal-addtopic' href='#curriculumtopic' data-courseid='$Course_ID' data-topictitle='$Unit_Title' data-topicid='$Unit_ID' data-topictheme='$Unit_Description' data-topicstarttime='$Unit_Start_Time' data-topicestimatenumberofdays='$Unit_Length'>Edit</li>";
										echo "<li class='mdl-menu__item removetopic'><a href='modules/".basename(__DIR__)."/topic_remove_process.php?curriculumtopicid=".$Unit_ID."' class='mdl-color-text--black'></a>Delete</a></li>";
									echo "</ul>";
								echo "</span>";
							}
						echo "</div>";

						echo "<div class='collapsible-body mdl-color--white' style='padding:25px'>";
							echo "<table><tr>";
								echo "<td style='vertical-align:top; padding:0;'>";
									echo "<div style='color:#777'>Theme<h4 style='margin-top:5px;' class='$textcolor'>$Unit_Description</h4></div>";
								echo "</td>";
								echo "<td style='vertical-align:top; padding:0; width:350px;' class='hide-on-small-only'>";
									echo "<div style='float:right; padding:0 0 0 20px; margin:0 0 0 40px; border-left:1px solid #e1e1e1; color:#777;'>Estimated Days<h4 style='line-height:0;' class='$textcolor'>$Unit_Length</h4></div>";
									echo "<div style='float:right; padding:0 0 0 20px; border-left:1px solid #e1e1e1; color:#777;'>Start Day<h4 style='line-height:0;' class='$textcolor'>$FormattedMonth $Unit_Start_Day</h4></div>";
								echo "</td>";
							echo "</tr></table>";
							echo "<div id='topiccontentsholder-$Unit_ID' style='clear: left;'>";

								require "pacingguide_contents.php";

							echo "</div>";
					echo "</div>";
			    echo "</li>";

			}

			echo "</ul>";

			if($unitcount==0){
				if($pagerestrictionsedit == ""){
					echo "<div class='center-align' style='font-size:16px;'>Click the '+' in the bottom right to add a topic to this curriculum map.";
				}else{
					echo "<div class='center-align' style='font-size:16px;'>There are no topics in this curriculum pacing guide.";
				}
			}

			echo "</div>";

			include "topic_button.php";


		}
	}

?>

	<script>

		$(function()
		{

			//Remove Topic from Curriculum
			$( ".removetopic" ).unbind().click(function()
			{
				event.preventDefault();
				var result = confirm("Delete the topic? This will delete all attached materials.");
				if (result) {
					$(this).closest(".topicholder").hide();
					var address = $(this).find("a").attr("href");
					$.ajax({
						type: 'POST',
						url: address,
						data: '',
					})

					//Show the notification
					.done(function(response) {

							//Register MDL Components
							mdlregister();

							var notification = document.querySelector('.mdl-js-snackbar');
							var data = { message: response };
							notification.MaterialSnackbar.showSnackbar(data);

					})
				}
			});

			//Call Accordion
			$('.collapsible').collapsible({ });

			$( ".menuui" ).unbind().click(function(event)
			{
 				$(".collapsible-header").removeClass(function(){
 					return "active";
  				});
  				$(".collapsible").collapsible({accordion: true});
				$(".collapsible").collapsible({accordion: false});
 			});

		});

	</script>
