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
	
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 

	$Course_ID=htmlspecialchars($_GET["id"], ENT_QUOTES);

	//Get Course Information
	include "../../core/abre_dbconnect.php";
	$sqllookup = "SELECT * FROM curriculum_course where ID='$Course_ID'";
	$result2 = $db->query($sqllookup);
	$setting_preferences=mysqli_num_rows($result2);
	while($row = $result2->fetch_assoc())
	{
		
		$Title=htmlspecialchars($row["Title"], ENT_QUOTES);

		echo "<div class='page_container page_container_limit'>";
		echo "<div class='row'><div class='col s12' style='padding:0 40px 0 40px;'><h5>$Title</h5></div></div>";
		
		echo "<ul class='collapsible popout' data-collapsible='accordion'>";
		
		$sqllookup2 = "SELECT * FROM curriculum_unit where Course_ID='$setting_preferences'";
		$result3 = $db->query($sqllookup2);
		while($row2 = $result3->fetch_assoc())
		{
	
			if (!empty($row2["Title"])){ $Unit_Title=stripslashes($row2["Title"]); }
			if (!empty($row2["Start_Time"])){ $Unit_Start_Time=stripslashes($row2["Start_Time"]); }
			if (!empty($row2["Length"])){ $Unit_Length=stripslashes($row2["Length"]); }
			if (!empty($row2["Description"])){ $Unit_Description=stripslashes($row2["Description"]); }
			if (!empty($row2["Standards"])){ $Unit_Standards=stripslashes($row2["Standards"]); }	
			if (!empty($row2["Resources"])){ $Unit_Resources=stripslashes($row2["Resources"]); }
			if (!empty($row2["Assessments"])){ $Unit_Assessments=stripslashes($row2["Assessments"]); }	
			if (!empty($row2["Lessons"])){ $Unit_Lessons=stripslashes($row2["Lessons"]); }
			$Current_Month = date('F');
			$Previous_Month = date('F', strtotime('-1 month'));
			
			
	
			echo "<li>";
			    	if(($Current_Month==$Unit_Start_Time))
			    	{
				    	echo "<div class='collapsible-header unit active'>";
			    		echo "<i class='material-icons mdl-color-text--green'>fiber_manual_record</i>";
			    	}
			    	else
			    	{
				    	echo "<div class='collapsible-header unit'>";
				    	echo "<i class='material-icons mdl-color-text--red'>fiber_manual_record</i>";
			    	}
					echo "<span class='title'>$Unit_Title</span>";
				echo "</div>";
				echo "<div class='collapsible-body mdl-color--white'>";
					echo "<p>";
						echo "<b>Start Time</b>: $Unit_Start_Time<br>";
						echo "<b>Estimated Time</b>: $Unit_Length Days<br>";
						echo "<b>Theme</b>: $Unit_Description<br><br>";
						echo "<b>Standards</b>:<br>";
						
						//List Attached Standards
						if($Unit_Standards==""){  $Unit_Standards="0"; }
						$sqllookup3 = "SELECT *  FROM curriculum_standards WHERE ID IN ($Unit_Standards)";
						$result4 = $db->query($sqllookup3);
						while($row3 = $result4->fetch_assoc())
						{
							$Unit_State_Standard=stripslashes($row3["State_Standard"]);
							$Unit_State_Standard_ID=stripslashes($row3["Standard_ID"]);
							echo "$Unit_State_Standard_ID - $Unit_State_Standard<br><br>";
						}
						if($Unit_Standards==0)
						{ 
							$Unit_State_Standard="No standards have been aligned."; 
							echo "$Unit_State_Standard<br><br>";
						}
						

						echo "<b>Resources</b>:<br>";

						//List Attached Resources
						if(empty($Unit_Resources))
						{ 
							echo "<span style='display:block; width:100%; background-color:#F5F5F5; border:1px solid #ccc; padding:20px;'>";
								echo "No available resources."; 
							echo"</span>";
						}
						else
						{
							$sqllookup6 = "SELECT *  FROM curriculum_resources WHERE ID IN ($Unit_Resources)";
							$result7 = $db->query($sqllookup6);
							while($row8 = $result7->fetch_assoc())
							{
								echo "<span style='display:block; width:100%; background-color:#F5F5F5; border:1px solid #ccc; padding:20px;'>";
									$Unit_Resource_Title=stripslashes($row8["Title"]);
									$Unit_Resource_Link=stripslashes($row8["Link"]);
									echo "<a href='$Unit_Resource_Link' target='_blank' class='mdl-color-text--blue-800'>$Unit_Resource_Title</a>";
								echo"</span>";
							}
						}
						echo"</span><br>";
						
						echo "<b>Assessments</b>:<br><br>";
						
						//List Attached Resources
						if(empty($Unit_Assessments))
						{ 
							echo "<span style='display:block; width:100%; background-color:#F5F5F5; border:1px solid #ccc; padding:20px;'>";
								echo "No available assessments."; 
							echo"</span>";
						}
						else
						{
							$sqllookup6 = "SELECT *  FROM curriculum_assessments WHERE ID IN ($Unit_Assessments)";
							$result7 = $db->query($sqllookup6);
							while($row8 = $result7->fetch_assoc())
							{
								echo "<span style='display:block; width:100%; background-color:#F5F5F5; border:1px solid #ccc; padding:20px;'>";
									$Unit_Assessment_Title=stripslashes($row8["Title"]);
									$Unit_Assessment_Link=stripslashes($row8["Link"]);
									echo "<a href='$Unit_Assessment_Link' target='_blank' class='mdl-color-text--blue-800'>$Unit_Assessment_Title</a>";
								echo"</span>";
							}
						}
						echo"</span><br>";
						
						echo "<b>Model Lessons</b>:<br><br>";
						
						//List Lessons
						if(empty($Unit_Lessons))
						{
							echo "<span style='display:block; width:100%; background-color:#F5F5F5; border:1px solid #ccc; padding:20px;'>";
								echo "No model lessons available."; 
							echo"</span>";
						}
						else
						{
							$sqllookup9 = "SELECT *  FROM curriculum_lesson WHERE ID IN ($Unit_Lessons)";
							$result11 = $db->query($sqllookup9);
							while($row12 = $result11->fetch_assoc())
							{
								echo "<span style='display:block; width:100%; background-color:#F5F5F5; border:1px solid #ccc; padding:20px;'>";
									$Unit_Lessons_Title=stripslashes($row12["Title"]);
									$Unit_Lessons_Link=stripslashes($row12["Link"]);
									echo "<a href='$Unit_Lessons_Link' class='mdl-color-text--blue-800'>$Unit_Lessons_Title</a>";
								echo"</span>";
							}
						}
						echo"</span><br>";
						
						
						
					echo "</p>";
				echo "</div>";
		    echo "</li>";
			
		}
	
		echo "</ul>";
		echo "</div>";
		
	}
?>
	
	<script>
		
		$(document).ready(function(){
			
			//Call Accordion
			$('.collapsible').collapsible({
				accordion : false
			});	
			
		});
		
	</script>